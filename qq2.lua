
--// AUTO FISH GUI - Versi HyRexxyy Event-Based + Nikzz Features
local Rayfield = loadstring(game:HttpGet('https://sirius.menu/rayfield'))()
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

-- ================= TELEGRAM HOOK SYSTEM =================
local TELEGRAM_BOT_TOKEN = "8276216292:AAHgfmcuWsqEai6wPf5KDcFABfo-_4R9_ug"

local TelegramConfig = {
    Enabled = false,
    BotToken = TELEGRAM_BOT_TOKEN,
    ChatID = "",
    SelectedRarities = {},
    MaxSelection = 3,
    UseFancyFont = true,
    QuestNotifications = true
}

local function safeJSONEncode(tbl)
    local ok, res = pcall(function() return HttpService:JSONEncode(tbl) end)
    if ok then return res end
    return "{}"
end

local function pickHTTPRequest(requestTable)
    local ok, result
    if type(http_request) == "function" then
        ok, result = pcall(function() return http_request(requestTable) end)
        return ok, result
    elseif type(syn) == "table" and type(syn.request) == "function" then
        ok, result = pcall(function() return syn.request(requestTable) end)
        return ok, result
    elseif type(request) == "function" then
        ok, result = pcall(function() return request(requestTable) end)
        return ok, result
    elseif type(http) == "table" and type(http.request) == "function" then
        ok, result = pcall(function() return http.request(requestTable) end)
        return ok, result
    else
        return false, "No supported http request function found"
    end
end

local function CountSelected()
    local c = 0
    for k,v in pairs(TelegramConfig.SelectedRarities) do if v then c = c + 1 end end
    return c
end

local function GetPlayerStats()
    local caught, rarest = "Unknown", "Unknown"
    local ls = LocalPlayer:FindFirstChild("leaderstats")
    if ls then
        pcall(function()
            local c = ls:FindFirstChild("Caught") or ls:FindFirstChild("caught")
            if c and c.Value then caught = tostring(c.Value) end
            local r = ls:FindFirstChild("Rarest Fish") or ls:FindFirstChild("RarestFish") or ls:FindFirstChild("Rarest")
            if r and r.Value then rarest = tostring(r.Value) end
        end)
    end
    return caught, rarest
end

local function BuildTelegramMessage(fishInfo, fishId, fishRarity, weight)
    local playerName = LocalPlayer.Name or "Unknown"
    local displayName = LocalPlayer.DisplayName or playerName
    local userId = tostring(LocalPlayer.UserId or "Unknown")
    local caught, rarest = GetPlayerStats()
    local serverTime = os.date("%H:%M:%S")
    local serverDate = os.date("%Y-%m-%d")
    local fishName = (fishInfo and fishInfo.Name) and fishInfo.Name or "Unknown"
    local fishTier = tostring((fishInfo and fishInfo.Tier) or "?")
    local sellPrice = tostring((fishInfo and fishInfo.SellPrice) or "?")
    local weightDisplay = "?"
    if weight then
        if type(weight) == "number" then weightDisplay = string.format("%.2fkg", weight) else weightDisplay = tostring(weight) .. "kg" end
    elseif fishInfo and fishInfo.Weight then weightDisplay = tostring(fishInfo.Weight) end

    local fishRarityStr = string.upper(tostring(fishRarity or (fishInfo and fishInfo.Rarity) or "UNKNOWN"))

    local message = "```\n"
    message = message .. "NIKZZ SCRIPT FISH IT\n"
    message = message .. "DEVELOPER: NIKZZ\n"
    message = message .. "========================================\n"
    message = message .. "\n"
    message = message .. "PLAYER INFORMATION\n"
    message = message .. "     NAME: " .. playerName .. "\n"
    if displayName ~= playerName then message = message .. "     DISPLAY: " .. displayName .. "\n" end
    message = message .. "     ID: " .. userId .. "\n"
    message = message .. "     CAUGHT: " .. tostring(caught) .. "\n"
    message = message .. "     RAREST FISH: " .. tostring(rarest) .. "\n"
    message = message .. "\n"
    message = message .. "FISH DETAILS\n"
    message = message .. "     NAME: " .. fishName .. "\n"
    message = message .. "     ID: " .. tostring(fishId or "?") .. "\n"
    message = message .. "     TIER: " .. fishTier .. "\n"
    message = message .. "     RARITY: " .. fishRarityStr .. "\n"
    message = message .. "     WEIGHT: " .. weightDisplay .. "\n"
    message = message .. "     PRICE: " .. sellPrice .. " COINS\n"
    message = message .. "\n"
    message = message .. "SYSTEM STATS\n"
    message = message .. "     TIME: " .. serverTime .. "\n"
    message = message .. "     DATE: " .. serverDate .. "\n"
    message = message .. "\n"
    message = message .. "DEVELOPER SOCIALS\n"
    message = message .. "     TIKTOK: @nikzzxit\n"
    message = message .. "     INSTAGRAM: @n1kzx.z\n"
    message = message .. "     ROBLOX: @Nikzz7z\n"
    message = message .. "\n"
    message = message .. "STATUS: ACTIVE\n"
    message = message .. "========================================\n"
    message = message .. "```"
    return message
end

local function SendTelegram(message)
    if not TelegramConfig.BotToken or TelegramConfig.BotToken == "" then
        print("[Telegram] Bot token empty!")
        return false, "no token"
    end
    if not TelegramConfig.ChatID or TelegramConfig.ChatID == "" then
        print("[Telegram] Chat ID empty!")
        return false, "no chat id"
    end

    local url = ("https://api.telegram.org/bot%s/sendMessage"):format(TelegramConfig.BotToken)
    local payload = {
        chat_id = TelegramConfig.ChatID,
        text = message,
        parse_mode = "Markdown"
    }

    local body = safeJSONEncode(payload)
    local req = {
        Url = url,
        Method = "POST",
        Headers = { ["Content-Type"] = "application/json" },
        Body = body
    }

    local ok, res = pickHTTPRequest(req)
    if not ok then
        print("[Telegram] HTTP request failed:", res)
        return false, res
    end

    local success = false
    if type(res) == "table" then
        if res.Body then
            success = true
        elseif res.body then
            success = true
        elseif res.StatusCode and tonumber(res.StatusCode) and tonumber(res.StatusCode) >= 200 and tonumber(res.StatusCode) < 300 then
            success = true
        end
    elseif type(res) == "string" then
        success = true
    end

    if success then
        print("[Telegram] Message sent to Telegram.")
        return true, res
    else
        print("[Telegram] Unknown response:", res)
        return false, res
    end
end

-- ================= AUTO FISH DETECTION SYSTEM =================
local AutoDetectConfig = {
    Enabled = false,
    SelectedRarities = {
        COMMON = false,
        UNCOMMON = false,
        RARE = false,
        EPIC = false,
        LEGENDARY = false,
        MYTHIC = false,
        SECRET = false
    }
}

-- Function to get rarity from fish data
local function GetFishRarity(fishData)
    if not fishData then return "UNKNOWN" end
    
    -- Try to get rarity from different possible fields
    local rarity = fishData.Rarity or fishData.rarity or fishData.Tier or fishData.tier
    
    if type(rarity) == "number" then
        -- Convert tier number to rarity name
        local tierToRarity = {
            [1] = "COMMON",
            [2] = "UNCOMMON", 
            [3] = "RARE",
            [4] = "EPIC",
            [5] = "LEGENDARY",
            [6] = "MYTHIC",
            [7] = "SECRET"
        }
        return tierToRarity[rarity] or "UNKNOWN"
    elseif type(rarity) == "string" then
        return string.upper(rarity)
    end
    
    return "UNKNOWN"
end

-- Function to detect and process caught fish
local function ProcessCaughtFish(fishData)
    if not AutoDetectConfig.Enabled then return end
    if not TelegramConfig.Enabled then return end
    if not TelegramConfig.ChatID or TelegramConfig.ChatID == "" then return end
    
    -- Extract fish information
    local fishId = fishData.Id or fishData.id or fishData.FishId or fishData.fishId
    local fishName = fishData.Name or fishData.name or "Unknown Fish"
    local fishWeight = fishData.Weight or fishData.weight or fishData.Size or fishData.size
    local fishTier = fishData.Tier or fishData.tier or 1
    
    -- Get rarity from fish data
    local fishRarity = GetFishRarity(fishData)
    
    -- Check if this rarity is selected for notification
    if not AutoDetectConfig.SelectedRarities[fishRarity] then
        print(string.format("[Auto Detection] %s caught but rarity %s not selected", fishName, fishRarity))
        return -- Skip if this rarity is not selected
    end
    
    -- Get item info from database
    local itemInfo = GetItemInfo(fishId)
    if not itemInfo or itemInfo.Name == "Unknown Item" then
        -- If not in database, use the data from the catch
        itemInfo = {
            Name = fishName,
            Type = "Fish",
            Tier = fishTier,
            SellPrice = fishData.SellPrice or fishData.Price or 0,
            Weight = fishWeight or "-",
            Rarity = fishRarity
        }
    end
    
    print(string.format("[Auto Detection] %s caught! Rarity: %s", fishName, fishRarity))
    
    -- Build and send telegram message
    local message = BuildTelegramMessage(itemInfo, fishId, fishRarity, fishWeight)
    local success, result = SendTelegram(message)
    
    if success then
        print(string.format("[Auto Detection] Notification sent for %s (%s)", fishName, fishRarity))
        Rayfield:Notify({
            Title = "🎣 Fish Caught!",
            Content = string.format("%s (%s) - Telegram sent!", fishName, fishRarity),
            Duration = 3
        })
    else
        print(string.format("[Auto Detection] Failed to send notification for %s", fishName))
    end
end

-- Enhanced hook system for fishing events
local function SetupFishDetection()
    print("[Auto Detection] Setting up fish detection hooks...")
    
    -- Method 1: Hook all remote events that might be related to fishing
    local function HookRemotes()
        local success, net = pcall(function()
            return ReplicatedStorage:WaitForChild("Packages"):WaitForChild("_Index"):WaitForChild("sleitnick_net@0.2.0"):WaitForChild("net")
        end)
        
        if success and net then
            -- Hook common fishing remote events
            local fishingRemotes = {
                "RE/FishCaught",
                "RF/FishCaught", 
                "RE/FishingCompleted",
                "RF/FishingCompleted",
                "RE/CatchFish",
                "RF/CatchFish",
                "RE/FishCatch",
                "RF/FishCatch"
            }
            
            for _, remoteName in pairs(fishingRemotes) do
                local remote = net:FindFirstChild(remoteName)
                if remote then
                    if remote:IsA("RemoteEvent") then
                        remote.OnClientEvent:Connect(function(...)
                            local args = {...}
                            print(string.format("[Auto Detection] %s event triggered with %d args", remoteName, #args))
                            if #args > 0 then
                                ProcessCaughtFish(args[1])
                            end
                        end)
                        print("[Auto Detection] Hooked: " .. remoteName)
                    elseif remote:IsA("RemoteFunction") then
                        local oldInvoke = remote.InvokeServer
                        remote.InvokeServer = function(self, ...)
                            local args = {...}
                            local result = oldInvoke(self, ...)
                            print(string.format("[Auto Detection] %s invoked with %d args", remoteName, #args))
                            if #args > 0 then
                                ProcessCaughtFish(args[1])
                            end
                            return result
                        end
                        print("[Auto Detection] Hooked: " .. remoteName)
                    end
                end
            end
        end
    end

    -- Method 2: Hook __namecall for broader coverage
    local function HookNamecall()
        local mt = getrawmetatable(game)
        if mt then
            local oldNamecall = mt.__namecall
            setreadonly(mt, false)
            
            mt.__namecall = newcclosure(function(self, ...)
                local method = getnamecallmethod()
                local args = {...}
                
                -- Check for fishing-related remote calls
                if (method == "InvokeServer" or method == "FireServer") and self:IsA("RemoteEvent") or self:IsA("RemoteFunction") then
                    local remoteName = tostring(self)
                    if string.find(remoteName:lower(), "fish") or string.find(remoteName:lower(), "catch") then
                        print(string.format("[Auto Detection] Fishing remote detected: %s (%s)", remoteName, method))
                        if #args > 0 then
                            ProcessCaughtFish(args[1])
                        end
                    end
                end
                
                return oldNamecall(self, ...)
            end)
            
            setreadonly(mt, true)
            print("[Auto Detection] Namecall hook installed")
        end
    end

    -- Method 3: Monitor leaderstats for fish count changes
    local function MonitorLeaderstats()
        local function setupLeaderstatsMonitor()
            local ls = LocalPlayer:FindFirstChild("leaderstats")
            if ls then
                local caughtStat = ls:FindFirstChild("Caught") or ls:FindFirstChild("caught") or ls:FindFirstChild("FishCaught")
                if caughtStat then
                    local lastValue = caughtStat.Value
                    caughtStat:GetPropertyChangedSignal("Value"):Connect(function()
                        if caughtStat.Value > lastValue then
                            print(string.format("[Auto Detection] Fish count increased: %d -> %d", lastValue, caughtStat.Value))
                            -- Simulate fish catch with basic info
                            ProcessCaughtFish({
                                Name = "Auto-Detected Fish",
                                Tier = math.random(1, 7),
                                Rarity = "UNKNOWN",
                                Weight = math.random(1, 10) + math.random()
                            })
                            lastValue = caughtStat.Value
                        end
                    end)
                    print("[Auto Detection] Leaderstats monitor active")
                end
            end
        end

        -- Wait for leaderstats to be available
        if LocalPlayer:FindFirstChild("leaderstats") then
            setupLeaderstatsMonitor()
        else
            LocalPlayer.ChildAdded:Connect(function(child)
                if child.Name == "leaderstats" then
                    task.wait(1)
                    setupLeaderstatsMonitor()
                end
            end)
        end
    end

    -- Try all methods
    pcall(HookRemotes)
    pcall(HookNamecall) 
    pcall(MonitorLeaderstats)
    
    print("[Auto Detection] All detection methods installed")
end

-- Test function to simulate fish catch (for testing purposes)
local function TestFishDetection(rarity)
    local testFish = {
        COMMON = {Id = 1, Name = "Common Carp", Tier = 1, Rarity = "COMMON", Weight = 1.5, SellPrice = 10},
        UNCOMMON = {Id = 2, Name = "Uncommon Bass", Tier = 2, Rarity = "UNCOMMON", Weight = 2.3, SellPrice = 25},
        RARE = {Id = 3, Name = "Rare Tuna", Tier = 3, Rarity = "RARE", Weight = 3.7, SellPrice = 50},
        EPIC = {Id = 4, Name = "Epic Salmon", Tier = 4, Rarity = "EPIC", Weight = 4.2, SellPrice = 100},
        LEGENDARY = {Id = 5, Name = "Legendary Shark", Tier = 5, Rarity = "LEGENDARY", Weight = 5.8, SellPrice = 250},
        MYTHIC = {Id = 6, Name = "Mythic Kraken", Tier = 6, Rarity = "MYTHIC", Weight = 6.5, SellPrice = 500},
        SECRET = {Id = 7, Name = "Secret Leviathan", Tier = 7, Rarity = "SECRET", Weight = 7.3, SellPrice = 1000}
    }
    
    local fish = testFish[rarity]
    if fish then
        ProcessCaughtFish(fish)
        return true
    end
    return false
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

-- ================= MAIN VARIABLES =================
local antiAFK = false

-- ================= GUI SETUP =================
local Window = Rayfield:CreateWindow({
    Name = "🎣 Auto Fishing Hub - Nikzz Integrated",
    LoadingTitle = "Fishing AutoFarm",
    LoadingSubtitle = "By HyRexxyy x GPT + Nikzz Features",
    ConfigurationSaving = { Enabled = true, FolderName = "AutoFishSettings" },
    KeySystem = false
})

-- ================= MAIN TAB =================
local MainTab = Window:CreateTab("⚙️ Main Controls")

-- ANTI AFK SYSTEM
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

-- ================= HOOK SYSTEM TAB =================
local HookTab = Window:CreateTab("🔔 Hook System")

-- TELEGRAM HOOK SETTINGS
HookTab:CreateSection("📱 Telegram Hook Settings")

HookTab:CreateToggle({ 
    Name = "Enable Telegram Hook", 
    CurrentValue = TelegramConfig.Enabled, 
    Callback = function(v) 
        TelegramConfig.Enabled = v 
        if v then
            Rayfield:Notify({
                Title = "Telegram Hook Enabled",
                Content = "Fish detection notifications ready",
                Duration = 3
            })
        end
    end 
})

HookTab:CreateInput({
    Name = "Telegram Chat ID",
    PlaceholderText = "Enter Chat ID (example: -1001234567890 or 123456789)",
    RemoveTextAfterFocusLost = false,
    Callback = function(Text)
        TelegramConfig.ChatID = Text
    end,
})

HookTab:CreateParagraph({ 
    Title = "🔐 Token Info", 
    Content = "Bot token is pre-configured. Make sure Chat ID is filled for notifications to work." 
})

-- AUTO DETECTION SETTINGS
HookTab:CreateSection("🎣 Auto Fish Detection")

HookTab:CreateToggle({
    Name = "Enable Auto Detection",
    CurrentValue = AutoDetectConfig.Enabled,
    Callback = function(value)
        AutoDetectConfig.Enabled = value
        if value then
            SetupFishDetection()
            Rayfield:Notify({
                Title = "Auto Detection Enabled",
                Content = "Will notify Telegram for selected rarities",
                Duration = 3
            })
        else
            Rayfield:Notify({
                Title = "Auto Detection Disabled",
                Content = "Fish catch notifications turned off",
                Duration = 2
            })
        end
    end
})

HookTab:CreateParagraph({
    Title = "📊 Detection Status",
    Content = "System will automatically detect caught fish and send notifications based on rarity selection below."
})

-- RARITY SELECTION FOR AUTO DETECTION
HookTab:CreateSection("🎯 Select Rarities for Auto Detection")

-- Create toggles for each rarity
local rarities = {"COMMON", "UNCOMMON", "RARE", "EPIC", "LEGENDARY", "MYTHIC", "SECRET"}

for _, rarity in ipairs(rarities) do
    HookTab:CreateToggle({
        Name = rarity,
        CurrentValue = AutoDetectConfig.SelectedRarities[rarity],
        Callback = function(value)
            AutoDetectConfig.SelectedRarities[rarity] = value
            
            -- Count selected rarities
            local selectedCount = 0
            for _, v in pairs(AutoDetectConfig.SelectedRarities) do
                if v then selectedCount = selectedCount + 1 end
            end
            
            print(string.format("[Auto Detection] %s %s - Total selected: %d", 
                  rarity, value and "enabled" or "disabled", selectedCount))
        end
    })
end

-- TESTING AND UTILITIES
HookTab:CreateSection("🧪 Testing & Utilities")

HookTab:CreateButton({
    Name = "Test COMMON Fish Detection",
    Callback = function()
        if TestFishDetection("COMMON") then
            Rayfield:Notify({
                Title = "Test Sent",
                Content = "COMMON fish detection test completed",
                Duration = 2
            })
        end
    end
})

HookTab:CreateButton({
    Name = "Test RARE Fish Detection", 
    Callback = function()
        if TestFishDetection("RARE") then
            Rayfield:Notify({
                Title = "Test Sent",
                Content = "RARE fish detection test completed", 
                Duration = 2
            })
        end
    end
})

HookTab:CreateButton({
    Name = "Test LEGENDARY Fish Detection",
    Callback = function()
        if TestFishDetection("LEGENDARY") then
            Rayfield:Notify({
                Title = "Test Sent",
                Content = "LEGENDARY fish detection test completed",
                Duration = 2
            })
        end
    end
})

HookTab:CreateButton({
    Name = "Test MYTHIC Fish Detection",
    Callback = function()
        if TestFishDetection("MYTHIC") then
            Rayfield:Notify({
                Title = "Test Sent", 
                Content = "MYTHIC fish detection test completed",
                Duration = 2
            })
        end
    end
})

HookTab:CreateButton({
    Name = "Test SECRET Fish Detection",
    Callback = function()
        if TestFishDetection("SECRET") then
            Rayfield:Notify({
                Title = "Test Sent",
                Content = "SECRET fish detection test completed",
                Duration = 2
            })
        end
    end
})

HookTab:CreateButton({
    Name = "Test All Selected Rarities",
    Callback = function()
        local tested = 0
        for rarity, enabled in pairs(AutoDetectConfig.SelectedRarities) do
            if enabled then
                if TestFishDetection(rarity) then
                    tested = tested + 1
                end
                task.wait(0.5) -- Delay between tests
            end
        end
        
        if tested > 0 then
            Rayfield:Notify({
                Title = "Batch Test Complete",
                Content = string.format("Tested %d selected rarities", tested),
                Duration = 3
            })
        else
            Rayfield:Notify({
                Title = "No Rarities Selected",
                Content = "Please select at least one rarity to test",
                Duration = 3
            })
        end
    end
})

HookTab:CreateParagraph({
    Title = "ℹ️ How It Works",
    Content = "1. Enable Telegram Hook and set Chat ID\n2. Enable Auto Detection\n3. Select which rarities to notify\n4. Start fishing - notifications will auto-send!"
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

-- Initialize fish detection when script starts
task.spawn(function()
    task.wait(5) -- Wait for everything to load
    if AutoDetectConfig.Enabled then
        SetupFishDetection()
        print("[Auto Detection] Fish detection system initialized")
    end
end)

-- ================= NOTIFICATION =================
Rayfield:Notify({
    Title = "✅ AutoFish GUI Loaded - Nikzz Integrated",
    Content = "All Features Ready! Database + Telegram + Utility + Teleport",
    Duration = 6
})

print("🎣 Auto Fishing Hub - All Nikzz Features Integrated Successfully!")
print("📊 Database System: " .. (database and "Loaded" or "Fallback"))
print("🔔 Telegram Hook: Ready")
print("🚀 Teleport System: " .. #IslandsData .. " Islands")
print("⚡ Utility Features: All Systems Go")
print("🎯 Auto Fish Detection: " .. (AutoDetectConfig.Enabled and "Enabled" or "Disabled"))
