--// AUTO FISH GUI
local Rayfield = loadstring(game:HttpGet('https://raw.githubusercontent.com/SiriusSoftwareLtd/Rayfield/main/source.lua'))()
local ReplicatedStorage = game:GetService("ReplicatedStorage")
local Players = game:GetService("Players")
local player = Players.LocalPlayer
local VirtualUser = game:GetService("VirtualUser")

-- ================= SERVICES =================
local Workspace = game:GetService("Workspace")
local Lighting = game:GetService("Lighting")
local RunService = game:GetService("RunService")
local UserInputService = game:GetService("UserInputService")
local TweenService = game:GetService("TweenService")
local TeleportService = game:GetService("TeleportService")
local HttpService = game:GetService("HttpService")

-- ================= PLAYER VARIABLES =================
local LocalPlayer = Players.LocalPlayer
local Character = LocalPlayer.Character or LocalPlayer.CharacterAdded:Wait()
local HumanoidRootPart = Character:WaitForChild("HumanoidRootPart")
local Humanoid = Character:WaitForChild("Humanoid")

-- ================= FISHING REMOTES =================
local net = ReplicatedStorage
    :WaitForChild("Packages")
    :WaitForChild("_Index")
    :WaitForChild("sleitnick_net@0.2.0")
    :WaitForChild("net")

local equipRemote = net:WaitForChild("RE/EquipToolFromHotbar")
local rodRemote = net:WaitForChild("RF/ChargeFishingRod")
local miniGameRemote = net:WaitForChild("RF/RequestFishingMinigameStarted")
local finishRemote = net:WaitForChild("RE/FishingCompleted")

-- ================= FISHING VARIABLES =================
local autofish = false
local perfectCast = false
local autoRecastDelay = 2
local fishCount = 0
local autoSell = false
local lastSellTime = 0
local antiAFK = false

-- ================= AUTO SELL CONFIG =================
local AUTO_SELL_THRESHOLD = 60
local AUTO_SELL_DELAY = 60

-- ================= DATABASE SYSTEM =================
local tierToRarity = {
    [1] = "COMMON",
    [2] = "UNCOMMON", 
    [3] = "RARE",
    [4] = "EPIC",
    [5] = "LEGENDARY",
    [6] = "MYTHIC",
    [7] = "SECRET"
}

local function LoadDatabase()
    local path = "FULL_ITEM_DATA.json"
    
    local success, content = pcall(function() 
        return readfile(path) 
    end)
    
    if success and content then
        local decodeSuccess, data = pcall(function() 
            return HttpService:JSONDecode(content) 
        end)
        
        if decodeSuccess and data then
            print("[DB] Loaded JSON from path:", path)
            return data
        else
            print("[DB] JSON parse failed for path:", path)
        end
    else
        print("[DB] File not found:", path)
    end
    
    print("[DB] FULL_ITEM_DATA.json not found")
    return nil
end

local database = LoadDatabase()
local ItemDatabase = {}

if database and database.Data then
    for cat, list in pairs(database.Data) do
        if type(list) == "table" then
            for key, item in pairs(list) do
                if type(item) == "table" then
                    local tierNum = tonumber(item.Tier) or 0
                    item.Rarity = (item.Rarity and string.upper(tostring(item.Rarity))) or (tierToRarity[tierNum] or "UNKNOWN")
                    if item.Id then
                        local idn = tonumber(item.Id)
                        if idn then item.Id = idn end
                    end
                end
            end
        end
    end

    for cat, list in pairs(database.Data) do
        if type(list) == "table" then
            for _, item in pairs(list) do
                if item and item.Id then
                    local id = tonumber(item.Id) or item.Id
                    local tierNum = tonumber(item.Tier) or 0
                    ItemDatabase[id] = {
                        Name = item.Name or tostring(id),
                        Type = item.Type or cat,
                        Tier = tierNum,
                        SellPrice = item.SellPrice or 0,
                        Weight = item.Weight or "-",
                        Rarity = (item.Rarity and string.upper(tostring(item.Rarity))) or (tierToRarity[tierNum] or "UNKNOWN"),
                        Raw = item
                    }
                end
            end
        end
    end

    print("[DATABASE] Loaded item database")
else
    print("[DATABASE] FULL_ITEM_DATA.json not found or invalid. Item DB empty.")
    
    ItemDatabase = {
        [1] = {Name = "Common Fish", Type = "Fish", Tier = 1, SellPrice = 10, Weight = "1-2kg", Rarity = "COMMON"},
        [2] = {Name = "Uncommon Fish", Type = "Fish", Tier = 2, SellPrice = 25, Weight = "2-3kg", Rarity = "UNCOMMON"},
        [3] = {Name = "Rare Fish", Type = "Fish", Tier = 3, SellPrice = 50, Weight = "3-4kg", Rarity = "RARE"},
        [4] = {Name = "Epic Fish", Type = "Fish", Tier = 4, SellPrice = 100, Weight = "4-5kg", Rarity = "EPIC"},
        [5] = {Name = "Legendary Fish", Type = "Fish", Tier = 5, SellPrice = 250, Weight = "5-6kg", Rarity = "LEGENDARY"},
        [6] = {Name = "Mythic Fish", Type = "Fish", Tier = 6, SellPrice = 500, Weight = "6-7kg", Rarity = "MYTHIC"},
        [7] = {Name = "Secret Fish", Type = "Fish", Tier = 7, SellPrice = 1000, Weight = "7-8kg", Rarity = "SECRET"}
    }
    print("[DATABASE] Using fallback database with basic fish data")
end

local function GetItemInfo(itemId)
    local info = ItemDatabase[itemId]
    if not info then
        return { Name = "Unknown Item", Type = "Unknown", Tier = 0, SellPrice = 0, Weight = "-", Rarity = "UNKNOWN" }
    end
    info.Rarity = string.upper(tostring(info.Rarity or "UNKNOWN"))
    return info
end

-- ================= FISHING FUNCTIONS =================
local function startAntiAFK()
    task.spawn(function()
        while antiAFK do
            pcall(function()
                VirtualUser:CaptureController()
                VirtualUser:ClickButton2(Vector2.new())
            end)
            task.wait(30)
        end
    end)
end

local function startAutoSell()
    task.spawn(function()
        while autoSell do
            pcall(function()
                local Replion = ReplicatedStorage:FindFirstChild("Replion")
                if not Replion then
                    task.wait(10)
                    return
                end
                
                local DataReplion = Replion.Client:WaitReplion("Data")
                local items = DataReplion and DataReplion:Get({"Inventory","Items"})
                if type(items) ~= "table" then return end
                
                local unfavoritedCount = 0
                for _, item in ipairs(items) do
                    if not item.Favorited then
                        unfavoritedCount = unfavoritedCount + (item.Count or 1)
                    end
                end
                
                if unfavoritedCount >= AUTO_SELL_THRESHOLD and os.time() - lastSellTime >= AUTO_SELL_DELAY then
                    local sellFunc = net:FindFirstChild("RF/SellAllItems")
                    if sellFunc then
                        task.spawn(sellFunc.InvokeServer, sellFunc)
                        Rayfield:Notify({
                            Title = "💰 Auto Sell",
                            Content = "Selling non-favorited items...",
                            Duration = 3
                        })
                        lastSellTime = os.time()
                    end
                end
            end)
            task.wait(10)
        end
    end)
end

local function AutoFishCycle()
    pcall(function()
        equipRemote:FireServer(1)
        task.wait(0.1)
        
        local timestamp = perfectCast and 9999999999 or (tick() + math.random())
        rodRemote:InvokeServer(timestamp)
        task.wait(0.5)
        
        local x = perfectCast and -1.238 or (math.random(-1000,1000)/1000)
        local y = perfectCast and 0.969 or (math.random(0,1000)/1000)
        miniGameRemote:InvokeServer(x, y)
        
        local caught = false
        local rodTool = player.Backpack:FindFirstChild("FishingRod") or player.Character:FindFirstChild("FishingRod")
        
        if rodTool then
            local connection
            connection = rodTool:GetAttributeChangedSignal("HasFish"):Connect(function()
                if rodTool:GetAttribute("HasFish") == true then
                    caught = true
                    connection:Disconnect()
                end
            end)
            
            local timer = 0
            while not caught and timer < 15 do
                task.wait(0.1)
                timer += 0.1
            end
        else
            task.wait(5)
        end
        
        finishRemote:FireServer()
        task.wait(0.1)
        finishRemote:FireServer()
        
        fishCount += 1
        CounterLabel:Set("🐟 Fish Caught: " .. fishCount)
    end)
end

-- ================= UTILITY FUNCTIONS =================
local Config = {
    WalkSpeed = 16,
    JumpPower = 50,
    NoClip = false,
    XRay = false,
    ESPEnabled = false,
    ESPDistance = 20,
    Brightness = 2,
    TimeOfDay = 14,
    AutoRejoin = false
}

local LightingConnection = nil

local function ApplyPermanentLighting()
    if LightingConnection then LightingConnection:Disconnect() end
    
    LightingConnection = RunService.Heartbeat:Connect(function()
        Lighting.Brightness = Config.Brightness
        Lighting.ClockTime = Config.TimeOfDay
    end)
end

local function RemoveFog()
    Lighting.FogEnd = 100000
    Lighting.FogStart = 0
    for _, effect in pairs(Lighting:GetChildren()) do
        if effect:IsA("Atmosphere") then
            effect.Density = 0
        end
    end
    
    RunService.Heartbeat:Connect(function()
        Lighting.FogEnd = 100000
        Lighting.FogStart = 0
    end)
end

local function Enable8Bit()
    task.spawn(function()
        print("[8-Bit Mode] Enabling super smooth rendering...")
        
        for _, obj in pairs(Workspace:GetDescendants()) do
            if obj:IsA("BasePart") then
                obj.Material = Enum.Material.SmoothPlastic
                obj.Reflectance = 0
                obj.CastShadow = false
                obj.TopSurface = Enum.SurfaceType.Smooth
                obj.BottomSurface = Enum.SurfaceType.Smooth
            end
            if obj:IsA("MeshPart") then
                obj.Material = Enum.Material.SmoothPlastic
                obj.Reflectance = 0
                obj.TextureID = ""
                obj.CastShadow = false
                obj.RenderFidelity = Enum.RenderFidelity.Performance
            end
            if obj:IsA("Decal") or obj:IsA("Texture") then
                obj.Transparency = 1
            end
            if obj:IsA("SpecialMesh") then
                obj.TextureId = ""
            end
        end
        
        for _, effect in pairs(Lighting:GetChildren()) do
            if effect:IsA("PostEffect") or effect:IsA("Atmosphere") then
                effect.Enabled = false
            end
        end
        
        Lighting.Brightness = 3
        Lighting.Ambient = Color3.fromRGB(255, 255, 255)
        Lighting.OutdoorAmbient = Color3.fromRGB(255, 255, 255)
        Lighting.GlobalShadows = false
        Lighting.FogEnd = 100000
        
        Workspace.DescendantAdded:Connect(function(obj)
            if obj:IsA("BasePart") then
                obj.Material = Enum.Material.SmoothPlastic
                obj.Reflectance = 0
                obj.CastShadow = false
                obj.TopSurface = Enum.SurfaceType.Smooth
                obj.BottomSurface = Enum.SurfaceType.Smooth
            end
            if obj:IsA("MeshPart") then
                obj.Material = Enum.Material.SmoothPlastic
                obj.Reflectance = 0
                obj.TextureID = ""
                obj.RenderFidelity = Enum.RenderFidelity.Performance
            end
            if obj:IsA("Decal") or obj:IsA("Texture") then
                obj.Transparency = 1
            end
        end)
        
        Rayfield:Notify({
            Title = "8-Bit Mode",
            Content = "Super smooth rendering enabled!",
            Duration = 2
        })
    end)
end

local function NoClip()
    task.spawn(function()
        while Config.NoClip do
            pcall(function()
                if Character then
                    for _, part in pairs(Character:GetChildren()) do
                        if part:IsA("BasePart") then
                            part.CanCollide = false
                        end
                    end
                end
            end)
            task.wait(0.1)
        end
    end)
end

local function XRay()
    task.spawn(function()
        while Config.XRay do
            pcall(function()
                for _, part in pairs(Workspace:GetDescendants()) do
                    if part:IsA("BasePart") and part.Transparency < 0.5 then
                        part.LocalTransparencyModifier = 0.5
                    end
                end
            end)
            task.wait(1)
        end
    end)
end

local function ESP()
    task.spawn(function()
        while Config.ESPEnabled do
            pcall(function()
                for _, player in pairs(Players:GetPlayers()) do
                    if player ~= LocalPlayer and player.Character and player.Character:FindFirstChild("HumanoidRootPart") then
                        local distance = (HumanoidRootPart.Position - player.Character.HumanoidRootPart.Position).Magnitude
                        if distance <= Config.ESPDistance then
                            -- ESP logic here
                        end
                    end
                end
            end)
            task.wait(1)
        end
    end)
end

-- ================= TELEPORT SYSTEM =================
local IslandsData = {
    {Name = "Fisherman Island", Position = Vector3.new(92, 9, 2768)},
    {Name = "Arrow Lever", Position = Vector3.new(898, 8, -363)},
    {Name = "Sisyphus Statue", Position = Vector3.new(-3740, -136, -1013)},
    {Name = "Ancient Jungle", Position = Vector3.new(1481, 11, -302)},
    {Name = "Weather Machine", Position = Vector3.new(-1519, 2, 1908)},
    {Name = "Coral Refs", Position = Vector3.new(-3105, 6, 2218)},
    {Name = "Tropical Island", Position = Vector3.new(-2110, 53, 3649)},
    {Name = "Kohana", Position = Vector3.new(-662, 3, 714)},
    {Name = "Esoteric Island", Position = Vector3.new(2035, 27, 1386)},
    {Name = "Diamond Lever", Position = Vector3.new(1818, 8, -285)},
    {Name = "Underground Cellar", Position = Vector3.new(2098, -92, -703)},
    {Name = "Volcano", Position = Vector3.new(-631, 54, 194)},
    {Name = "Enchant Room", Position = Vector3.new(3255, -1302, 1371)},
    {Name = "Lost Isle", Position = Vector3.new(-3717, 5, -1079)},
    {Name = "Sacred Temple", Position = Vector3.new(1475, -22, -630)},
    {Name = "Creater Island", Position = Vector3.new(981, 41, 5080)},
    {Name = "Double Enchant Room", Position = Vector3.new(1480, 127, -590)},
    {Name = "Treassure Room", Position = Vector3.new(-3599, -276, -1642)},
    {Name = "Crescent Lever", Position = Vector3.new(1419, 31, 78)},
    {Name = "Hourglass Diamond Lever", Position = Vector3.new(1484, 8, -862)},
    {Name = "Snow Island", Position = Vector3.new(1627, 4, 3288)}
}

local function TeleportToPosition(pos)
    if HumanoidRootPart then
        HumanoidRootPart.CFrame = CFrame.new(pos)
        return true
    end
    return false
end

-- ================= AUTO REJOIN SYSTEM =================
local RejoinData = {
    Position = nil,
    ActiveFeatures = {},
    Settings = {}
}

local RejoinSaveFile = "NikzzRejoinData_" .. LocalPlayer.UserId .. ".json"

local function SaveRejoinData()
    RejoinData.Position = HumanoidRootPart.CFrame
    RejoinData.Settings = {
        WalkSpeed = Config.WalkSpeed,
        JumpPower = Config.JumpPower,
        Brightness = Config.Brightness,
        TimeOfDay = Config.TimeOfDay
    }
    
    writefile(RejoinSaveFile, HttpService:JSONEncode(RejoinData))
    print("[AUTO REJOIN] Data saved for reconnection")
end

local function LoadRejoinData()
    if isfile(RejoinSaveFile) then
        local success, data = pcall(function()
            return HttpService:JSONDecode(readfile(RejoinSaveFile))
        end)
        
        if success and data then
            RejoinData = data
            
            if RejoinData.Position and HumanoidRootPart then
                HumanoidRootPart.CFrame = RejoinData.Position
                print("[AUTO REJOIN] Position restored")
            end
            
            if RejoinData.Settings then
                for key, value in pairs(RejoinData.Settings) do
                    if Config[key] ~= nil then
                        Config[key] = value
                    end
                end
            end
            
            if Humanoid then
                Humanoid.WalkSpeed = Config.WalkSpeed
                Humanoid.JumpPower = Config.JumpPower
            end
            
            Lighting.Brightness = Config.Brightness
            Lighting.ClockTime = Config.TimeOfDay
            
            print("[AUTO REJOIN] All settings and features restored")
            return true
        end
    end
    return false
end

local function SetupAutoRejoin()
    if Config.AutoRejoin then
        print("[AUTO REJOIN] System enabled")
        
        task.spawn(function()
            while Config.AutoRejoin do
                SaveRejoinData()
                task.wait(10)
            end
        end)
        
        task.spawn(function()
            local success = pcall(function()
                game:GetService("CoreGui").RobloxPromptGui.promptOverlay.ChildAdded:Connect(function(child)
                    if Config.AutoRejoin then
                        if child.Name == 'ErrorPrompt' then
                            task.wait(1)
                            SaveRejoinData()
                            task.wait(1)
                            TeleportService:Teleport(game.PlaceId, LocalPlayer)
                        end
                    end
                end)
            end)
            
            if not success then
                warn("[AUTO REJOIN] Method 1 failed to setup")
            end
        end)
        
        task.spawn(function()
            game:GetService("GuiService").ErrorMessageChanged:Connect(function()
                if Config.AutoRejoin then
                    task.wait(1)
                    SaveRejoinData()
                    task.wait(1)
                    TeleportService:Teleport(game.PlaceId, LocalPlayer)
                end
            end)
        end)
        
        LocalPlayer.OnTeleport:Connect(function(State)
            if Config.AutoRejoin and State == Enum.TeleportState.Failed then
                task.wait(1)
                SaveRejoinData()
                task.wait(1)
                TeleportService:Teleport(game.PlaceId, LocalPlayer)
            end
        end)
        
        Rayfield:Notify({
            Title = "Auto Rejoin",
            Content = "Protection active! Will rejoin on disconnect",
            Duration = 3
        })
    end
end

-- ================= GUI SETUP =================
local Window = Rayfield:CreateWindow({
    Name = "🎣 FishIt! - @h4pna",
    LoadingTitle = "FishIt! Hub",
    LoadingSubtitle = "Made with Love <3",
    ConfigurationSaving = { Enabled = true, FolderName = "AutoFishSettings" },
    KeySystem = false
})

-- ================= MAIN TAB =================
local MainTab = Window:CreateTab("⚙️ Main Controls")

-- FISH COUNTER LABEL
local CounterLabel = MainTab:CreateLabel("🐟 Fish Caught: 0")

-- AUTO FISHING TOGGLE
MainTab:CreateToggle({
    Name = "🎣 Enable Auto Fishing",
    CurrentValue = false,
    Callback = function(val)
        autofish = val
        if val then
            task.spawn(function()
                while autofish do
                    AutoFishCycle()
                    task.wait(autoRecastDelay)
                end
            end)
            Rayfield:Notify({
                Title = "✅ Auto Fishing Enabled",
                Content = "Auto fishing system activated!",
                Duration = 4
            })
        else
            Rayfield:Notify({
                Title = "❌ Auto Fishing Disabled",
                Content = "Auto fishing system turned off",
                Duration = 3
            })
        end
    end
})

-- PERFECT CAST TOGGLE
MainTab:CreateToggle({
    Name = "✨ Use Perfect Cast",
    CurrentValue = false,
    Callback = function(val)
        perfectCast = val
        Rayfield:Notify({
            Title = "Perfect Cast",
            Content = val and "Enabled - Perfect catches every time!" or "Disabled - Random casting",
            Duration = 3
        })
    end
})

-- AUTO RECAST DELAY SLIDER
MainTab:CreateSlider({
    Name = "⏱️ Auto Recast Delay (seconds)",
    Range = {0.5, 5},
    Increment = 0.1,
    CurrentValue = autoRecastDelay,
    Callback = function(val)
        autoRecastDelay = val
        Rayfield:Notify({
            Title = "Recast Delay Updated",
            Content = "Delay set to " .. val .. " seconds",
            Duration = 2
        })
    end
})

-- AUTO SELL TOGGLE
MainTab:CreateToggle({
    Name = "💰 Auto Sell Non-Favorited Fish",
    CurrentValue = false,
    Callback = function(val)
        autoSell = val
        if val then
            startAutoSell()
            Rayfield:Notify({
                Title = "✅ Auto Sell Enabled",
                Content = "Will automatically sell when non-favorited fish > " .. AUTO_SELL_THRESHOLD,
                Duration = 4
            })
        else
            Rayfield:Notify({
                Title = "❌ Auto Sell Disabled",
                Content = "Auto selling feature turned off",
                Duration = 3
            })
        end
    end
})

-- MANUAL SELL BUTTON
MainTab:CreateButton({
    Name = "🛒 Sell All Non-Favorited Fish Now",
    Callback = function()
        pcall(function()
            local sellFunc = net:FindFirstChild("RF/SellAllItems")
            if sellFunc then
                sellFunc:InvokeServer()
                Rayfield:Notify({
                    Title = "✅ Manual Sell",
                    Content = "Sold all non-favorited items!",
                    Duration = 3
                })
                lastSellTime = os.time()
            else
                Rayfield:Notify({
                    Title = "❌ Sell Failed",
                    Content = "Sell function not found",
                    Duration = 3
                })
            end
        end)
    end
})

-- ANTI AFK SYSTEM
MainTab:CreateToggle({
    Name = "🛡️ Anti AFK",
    CurrentValue = false,
    Callback = function(val)
        antiAFK = val
        if val then
            startAntiAFK()
            Rayfield:Notify({
                Title = "✅ Anti AFK Enabled",
                Content = "You will not be kicked for inactivity",
                Duration = 4
            })
        else
            Rayfield:Notify({
                Title = "❌ Anti AFK Disabled",
                Content = "AFK protection turned off",
                Duration = 3
            })
        end
    end
})

-- CLOSE GUI BUTTON
MainTab:CreateButton({
    Name = "❌ Close GUI",
    Callback = function()
        Rayfield:Destroy()
    end
})

-- ================= TELEPORT TAB =================
local TeleportTab = Window:CreateTab("🚀 Teleport")

-- ISLANDS SECTION
TeleportTab:CreateSection("🏝️ Islands")

local IslandOptions = {}
for i, island in ipairs(IslandsData) do
    table.insert(IslandOptions, string.format("%d. %s", i, island.Name))
end

local IslandDrop = TeleportTab:CreateDropdown({
    Name = "Select Island",
    Options = IslandOptions,
    CurrentOption = {IslandOptions[1]},
    Callback = function(Option) end
})

TeleportTab:CreateButton({
    Name = "Teleport to Island",
    Callback = function()
        local selected = IslandDrop.CurrentOption[1]
        local index = tonumber(selected:match("^(%d+)%."))
        
        if index and IslandsData[index] then
            TeleportToPosition(IslandsData[index].Position)
            Rayfield:Notify({
                Title = "Teleported",
                Content = "Teleported to " .. IslandsData[index].Name,
                Duration = 2
            })
        end
    end
})

-- PLAYERS SECTION
TeleportTab:CreateSection("👥 Players")

local PlayerDrop = TeleportTab:CreateDropdown({
    Name = "Select Player",
    Options = {"Load players first"},
    CurrentOption = {"Load players first"},
    Callback = function(Option) end
})

TeleportTab:CreateButton({
    Name = "Load Players",
    Callback = function()
        local Players_List = {}
        for _, player in pairs(Players:GetPlayers()) do
            if player ~= LocalPlayer and player.Character then
                table.insert(Players_List, player.Name)
            end
        end
        
        if #Players_List == 0 then
            Players_List = {"No players online"}
        end
        
        PlayerDrop:Refresh(Players_List)
        Rayfield:Notify({
            Title = "Players Loaded",
            Content = string.format("Found %d players", #Players_List),
            Duration = 2
        })
    end
})

TeleportTab:CreateButton({
    Name = "Teleport to Player",
    Callback = function()
        local selected = PlayerDrop.CurrentOption[1]
        local player = Players:FindFirstChild(selected)
        
        if player and player.Character then
            local hrp = player.Character:FindFirstChild("HumanoidRootPart")
            if hrp then
                HumanoidRootPart.CFrame = hrp.CFrame * CFrame.new(0, 3, 0)
                Rayfield:Notify({Title = "Teleported", Content = "Teleported to " .. selected, Duration = 2})
            end
        end
    end
})

-- POSITION MANAGER
TeleportTab:CreateSection("📍 Position Manager")

local SavedPosition = nil

TeleportTab:CreateButton({
    Name = "Save Current Position",
    Callback = function()
        SavedPosition = HumanoidRootPart.CFrame
        Rayfield:Notify({Title = "Saved", Content = "Position saved", Duration = 2})
    end
})

TeleportTab:CreateButton({
    Name = "Teleport to Saved Position",
    Callback = function()
        if SavedPosition then
            HumanoidRootPart.CFrame = SavedPosition
            Rayfield:Notify({Title = "Teleported", Content = "Loaded saved position", Duration = 2})
        else
            Rayfield:Notify({Title = "Error", Content = "No saved position", Duration = 2})
        end
    end
})

-- ================= UTILITY TAB =================
local UtilityTab = Window:CreateTab("⚡ Utility")

-- SPEED SETTINGS
UtilityTab:CreateSection("🏃 Speed Settings")

UtilityTab:CreateSlider({
    Name = "Walk Speed",
    Range = {16, 500},
    Increment = 1,
    CurrentValue = Config.WalkSpeed,
    Callback = function(Value)
        Config.WalkSpeed = Value
        if Humanoid then
            Humanoid.WalkSpeed = Value
        end
    end
})

UtilityTab:CreateSlider({
    Name = "Jump Power",
    Range = {50, 500},
    Increment = 5,
    CurrentValue = Config.JumpPower,
    Callback = function(Value)
        Config.JumpPower = Value
        if Humanoid then
            Humanoid.JumpPower = Value
        end
    end
})

UtilityTab:CreateInput({
    Name = "Custom Speed (Default: 16)",
    PlaceholderText = "Enter any speed value",
    RemoveTextAfterFocusLost = false,
    Callback = function(Text)
        local speed = tonumber(Text)
        if speed and speed >= 1 then
            if Humanoid then
                Humanoid.WalkSpeed = speed
                Config.WalkSpeed = speed
                Rayfield:Notify({Title = "Speed Set", Content = "Speed: " .. speed, Duration = 2})
            end
        end
    end
})

UtilityTab:CreateButton({
    Name = "Reset Speed to Normal",
    Callback = function()
        if Humanoid then
            Humanoid.WalkSpeed = 16
            Humanoid.JumpPower = 50
            Config.WalkSpeed = 16
            Config.JumpPower = 50
            Rayfield:Notify({Title = "Speed Reset", Content = "Back to normal", Duration = 2})
        end
    end
})

-- EXTRA UTILITY
UtilityTab:CreateSection("🔧 Extra Utility")

UtilityTab:CreateToggle({
    Name = "NoClip",
    CurrentValue = Config.NoClip,
    Callback = function(Value)
        Config.NoClip = Value
        if Value then
            NoClip()
        end
        Rayfield:Notify({
            Title = "NoClip",
            Content = Value and "Enabled" or "Disabled",
            Duration = 2
        })
    end
})

UtilityTab:CreateToggle({
    Name = "XRay (Transparent Walls)",
    CurrentValue = Config.XRay,
    Callback = function(Value)
        Config.XRay = Value
        if Value then
            XRay()
        end
        Rayfield:Notify({
            Title = "XRay Mode",
            Content = Value and "Enabled" or "Disabled",
            Duration = 2
        })
    end
})

UtilityTab:CreateButton({
    Name = "Infinite Jump",
    Callback = function()
        UserInputService.JumpRequest:Connect(function()
            if Humanoid then
                Humanoid:ChangeState(Enum.HumanoidStateType.Jumping)
            end
        end)
        Rayfield:Notify({Title = "Infinite Jump", Content = "Enabled", Duration = 2})
    end
})

-- PLAYER ESP
UtilityTab:CreateSection("👁️ Player ESP")

UtilityTab:CreateToggle({
    Name = "Enable ESP",
    CurrentValue = Config.ESPEnabled,
    Callback = function(Value)
        Config.ESPEnabled = Value
        if Value then
            ESP()
        end
        Rayfield:Notify({
            Title = "ESP",
            Content = Value and "Enabled" or "Disabled",
            Duration = 2
        })
    end
})

UtilityTab:CreateSlider({
    Name = "ESP Distance",
    Range = {10, 100},
    Increment = 5,
    CurrentValue = Config.ESPDistance,
    Callback = function(Value)
        Config.ESPDistance = Value
    end
})

UtilityTab:CreateButton({
    Name = "Highlight All Players",
    Callback = function()
        for _, player in pairs(Players:GetPlayers()) do
            if player ~= LocalPlayer and player.Character then
                local highlight = Instance.new("Highlight", player.Character)
                highlight.FillColor = Color3.fromRGB(255, 0, 0)
                highlight.OutlineColor = Color3.fromRGB(255, 255, 255)
                highlight.FillTransparency = 0.5
            end
        end
        Rayfield:Notify({Title = "ESP Enabled", Content = "All players highlighted", Duration = 2})
    end
})

UtilityTab:CreateButton({
    Name = "Remove All Highlights",
    Callback = function()
        for _, player in pairs(Players:GetPlayers()) do
            if player.Character then
                for _, obj in pairs(player.Character:GetChildren()) do
                    if obj:IsA("Highlight") then
                        obj:Destroy()
                    end
                end
            end
        end
        Rayfield:Notify({Title = "ESP Disabled", Content = "Highlights removed", Duration = 2})
    end
})

-- LIGHTING & GRAPHICS
UtilityTab:CreateSection("💡 Lighting & Graphics")

UtilityTab:CreateButton({
    Name = "Fullbright",
    Callback = function()
        Config.Brightness = 3
        Config.TimeOfDay = 14
        Lighting.Brightness = 3
        Lighting.ClockTime = 14
        Lighting.FogEnd = 100000
        Lighting.GlobalShadows = false
        Lighting.OutdoorAmbient = Color3.fromRGB(200, 200, 200)
        ApplyPermanentLighting()
        Rayfield:Notify({Title = "Fullbright", Content = "Maximum brightness (Permanent)", Duration = 2})
    end
})

UtilityTab:CreateButton({
    Name = "Remove Fog",
    Callback = function()
        RemoveFog()
        Rayfield:Notify({Title = "Fog Removed", Content = "Fog disabled permanently", Duration = 2})
    end
})

UtilityTab:CreateButton({
    Name = "8-Bit Mode (5x Smoother)",
    Callback = function()
        Enable8Bit()
        Rayfield:Notify({Title = "8-Bit Mode", Content = "Ultra smooth graphics enabled", Duration = 2})
    end
})

UtilityTab:CreateSlider({
    Name = "Brightness (Permanent)",
    Range = {0, 10},
    Increment = 0.5,
    CurrentValue = Config.Brightness,
    Callback = function(Value)
        Config.Brightness = Value
        Lighting.Brightness = Value
        ApplyPermanentLighting()
    end
})

UtilityTab:CreateSlider({
    Name = "Time of Day (Permanent)",
    Range = {0, 24},
    Increment = 0.5,
    CurrentValue = Config.TimeOfDay,
    Callback = function(Value)
        Config.TimeOfDay = Value
        Lighting.ClockTime = Value
        ApplyPermanentLighting()
    end
})

UtilityTab:CreateButton({
    Name = "Reset Graphics",
    Callback = function()
        if LightingConnection then LightingConnection:Disconnect() end
        Config.Brightness = 2
        Config.TimeOfDay = 14
        Lighting.Brightness = 2
        Lighting.FogEnd = 10000
        Lighting.GlobalShadows = true
        Lighting.ClockTime = 14
        settings().Rendering.QualityLevel = Enum.QualityLevel.Automatic
        Rayfield:Notify({Title = "Graphics Reset", Content = "Back to normal", Duration = 2})
    end
})

-- AUTO REJOIN
UtilityTab:CreateSection("🔄 Auto Rejoin")

UtilityTab:CreateToggle({
    Name = "Auto Rejoin on Disconnect",
    CurrentValue = Config.AutoRejoin,
    Callback = function(Value)
        Config.AutoRejoin = Value
        if Value then
            SetupAutoRejoin()
            Rayfield:Notify({
                Title = "Auto Rejoin",
                Content = "Will auto rejoin if disconnected!",
                Duration = 3
            })
        end
    end
})

-- SERVER
UtilityTab:CreateSection("🌐 Server")

UtilityTab:CreateButton({
    Name = "Show Server Stats",
    Callback = function()
        local stats = string.format(
            "=== SERVER STATS ===\n" ..
            "Players: %d/%d\n" ..
            "Ping: %d ms\n" ..
            "FPS: %d\n" ..
            "Job ID: %s\n" ..
            "=== END ===",
            #Players:GetPlayers(),
            Players.MaxPlayers,
            LocalPlayer:GetNetworkPing() * 1000,
            workspace:GetRealPhysicsFPS(),
            game.JobId
        )
        print(stats)
        Rayfield:Notify({Title = "Server Stats", Content = "Check console (F9)", Duration = 3})
    end
})

UtilityTab:CreateButton({
    Name = "Copy Job ID",
    Callback = function()
        setclipboard(game.JobId)
        Rayfield:Notify({Title = "Copied", Content = "Job ID copied to clipboard", Duration = 2})
    end
})

UtilityTab:CreateButton({
    Name = "Rejoin Server (Same)",
    Callback = function()
        TeleportService:TeleportToPlaceInstance(game.PlaceId, game.JobId, LocalPlayer)
    end
})

UtilityTab:CreateButton({
    Name = "Rejoin Server (Random)",
    Callback = function()
        TeleportService:Teleport(game.PlaceId, LocalPlayer)
    end
})

-- ================= INITIALIZATION =================
-- CHARACTER RESPAWN HANDLER
LocalPlayer.CharacterAdded:Connect(function(char)
    Character = char
    HumanoidRootPart = char:WaitForChild("HumanoidRootPart")
    Humanoid = char:WaitForChild("Humanoid")
    
    task.wait(2)
    
    if Humanoid then
        Humanoid.WalkSpeed = Config.WalkSpeed
        Humanoid.JumpPower = Config.JumpPower
    end
end)

-- AUTO LOAD SETTINGS
task.spawn(function()
    task.wait(3)
    
    if Humanoid then
        Humanoid.WalkSpeed = Config.WalkSpeed
        Humanoid.JumpPower = Config.JumpPower
    end
    
    Lighting.Brightness = Config.Brightness
    Lighting.ClockTime = Config.TimeOfDay
    
    if Config.AutoRejoin then
        LoadRejoinData()
    end
    
    print("✅ All features loaded successfully!")
end)

-- ================= NOTIFICATION =================
Rayfield:Notify({
    Title = "✅ AutoFish GUI Loaded - Nikzz Integrated",
    Content = "All Features Ready! Database + Utility + Teleport + Auto Fishing",
    Duration = 6
})

print("🎣 Auto Fishing Hub - All Nikzz Features Integrated Successfully!")
print("📊 Database System: " .. (database and "Loaded" or "Fallback"))
print("🚀 Teleport System: " .. #IslandsData .. " Islands")
print("⚡ Utility Features: All Systems Go")
print("🎣 Auto Fishing: Ready with Perfect Cast & Auto Sell")
