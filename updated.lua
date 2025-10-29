--// AUTO FISH GUI - Versi HyRexxyy Event-Based
local Rayfield = loadstring(game:HttpGet('https://sirius.menu/rayfield'))()
local ReplicatedStorage = game:GetService("ReplicatedStorage")
local Players = game:GetService("Players")
local player = Players.LocalPlayer
local VirtualUser = game:GetService("VirtualUser")
local TeleportService = game:GetService("TeleportService")
local HttpService = game:GetService("HttpService")
local Lighting = game:GetService("Lighting")
local RunService = game:GetService("RunService")
local UserInputService = game:GetService("UserInputService")

-- Lokasi Remote
local net = ReplicatedStorage
    :WaitForChild("Packages")
    :WaitForChild("_Index")
    :WaitForChild("sleitnick_net@0.2.0")
    :WaitForChild("net")

-- Remote penting
local equipRemote = net:WaitForChild("RE/EquipToolFromHotbar")
local rodRemote = net:WaitForChild("RF/ChargeFishingRod")
local miniGameRemote = net:WaitForChild("RF/RequestFishingMinigameStarted")
local finishRemote = net:WaitForChild("RE/FishingCompleted")

-- Variabel utama
local autofish = false
local perfectCast = false
local autoRecastDelay = 2
local fishCount = 0
local autoSell = false
local lastSellTime = 0
local antiAFK = false
local autoJump = false
local autoJumpDelay = 3
local walkOnWater = false
local noClip = false
local xRay = false
local espEnabled = false
local espDistance = 20
local infiniteZoom = false
local lockedPosition = false
local lockCFrame = nil
local autoRejoin = false
local brightness = 2
local timeOfDay = 14

-- Konfigurasi Auto Sell
local AUTO_SELL_THRESHOLD = 60 -- Jual ketika ikan non-favorit > 60
local AUTO_SELL_DELAY = 60 -- Delay minimum antara penjualan (detik)

-- Data Teleport
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

-- Data Events
local eventsList = {"Shark Hunt", "Ghost Shark Hunt", "Worm Hunt", "Black Hole", "Shocked", "Ghost Worm", "Meteor Rain"}

-- GUI Setup
local Window = Rayfield:CreateWindow({
    Name = "🎣 Auto Fishing Hub",
    LoadingTitle = "Fishing AutoFarm",
    LoadingSubtitle = "By HyRexxyy x GPT",
    ConfigurationSaving = { Enabled = true, FolderName = "AutoFishSettings" },
    KeySystem = false
})

local MainTab = Window:CreateTab("⚙️ Main Controls")
local UtilityTab = Window:CreateTab("🔧 Utility")
local TeleportTab = Window:CreateTab("🌍 Teleport")
local VisualTab = Window:CreateTab("🎨 Visual")
local ServerTab = Window:CreateTab("🌐 Server")

local CounterLabel = MainTab:CreateLabel("🐟 Fish Caught: 0")

-- ================= FUNGSI UTILITY =================

-- Fungsi AntiAFK
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

-- Fungsi Auto Jump
local function startAutoJump()
    task.spawn(function()
        while autoJump do
            pcall(function()
                local character = player.Character
                if character and character:FindFirstChild("Humanoid") then
                    local humanoid = character.Humanoid
                    if humanoid.FloorMaterial ~= Enum.Material.Air then
                        humanoid:ChangeState(Enum.HumanoidStateType.Jumping)
                    end
                end
            end)
            task.wait(autoJumpDelay)
        end
    end)
end

-- Fungsi Walk on Water
local walkOnWaterConnection = nil
local function startWalkOnWater()
    if walkOnWaterConnection then
        walkOnWaterConnection:Disconnect()
        walkOnWaterConnection = nil
    end
    
    walkOnWaterConnection = RunService.Heartbeat:Connect(function()
        if not walkOnWater then
            if walkOnWaterConnection then
                walkOnWaterConnection:Disconnect()
                walkOnWaterConnection = nil
            end
            return
        end
        
        pcall(function()
            local character = player.Character
            if character and character:FindFirstChild("HumanoidRootPart") then
                local humanoidRootPart = character.HumanoidRootPart
                local rayOrigin = humanoidRootPart.Position
                local rayDirection = Vector3.new(0, -20, 0)
                
                local raycastParams = RaycastParams.new()
                raycastParams.FilterDescendantsInstances = {character}
                raycastParams.FilterType = Enum.RaycastFilterType.Blacklist
                
                local raycastResult = workspace:Raycast(rayOrigin, rayDirection, raycastParams)
                
                if raycastResult and raycastResult.Instance then
                    local hitPart = raycastResult.Instance
                    
                    if hitPart.Name:lower():find("water") or hitPart.Material == Enum.Material.Water then
                        local waterSurfaceY = raycastResult.Position.Y
                        local playerY = humanoidRootPart.Position.Y
                        
                        if playerY < waterSurfaceY + 3 then
                            local newPosition = Vector3.new(
                                humanoidRootPart.Position.X,
                                waterSurfaceY + 3.5,
                                humanoidRootPart.Position.Z
                            )
                            humanoidRootPart.CFrame = CFrame.new(newPosition)
                        end
                    end
                end
            end
        end)
    end)
end

-- Fungsi NoClip
local function startNoClip()
    task.spawn(function()
        while noClip do
            pcall(function()
                local character = player.Character
                if character then
                    for _, part in pairs(character:GetChildren()) do
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

-- Fungsi XRay
local function startXRay()
    task.spawn(function()
        while xRay do
            pcall(function()
                for _, part in pairs(workspace:GetDescendants()) do
                    if part:IsA("BasePart") and part.Transparency < 0.5 then
                        part.LocalTransparencyModifier = 0.5
                    end
                end
            end)
            task.wait(1)
        end
    end)
end

-- Fungsi ESP
local function startESP()
    task.spawn(function()
        while espEnabled do
            pcall(function()
                local character = player.Character
                if character and character:FindFirstChild("HumanoidRootPart") then
                    local humanoidRootPart = character.HumanoidRootPart
                    
                    for _, otherPlayer in pairs(Players:GetPlayers()) do
                        if otherPlayer ~= player and otherPlayer.Character then
                            local otherHRP = otherPlayer.Character:FindFirstChild("HumanoidRootPart")
                            if otherHRP then
                                local distance = (humanoidRootPart.Position - otherHRP.Position).Magnitude
                                if distance <= espDistance then
                                    -- ESP logic bisa ditambahkan di sini
                                end
                            end
                        end
                    end
                end
            end)
            task.wait(1)
        end
    end)
end

-- Fungsi Lock Position
local function startLockPosition()
    task.spawn(function()
        while lockedPosition do
            local character = player.Character
            if character and character:FindFirstChild("HumanoidRootPart") then
                character.HumanoidRootPart.CFrame = lockCFrame
            end
            task.wait()
        end
    end)
end

-- Fungsi Infinite Zoom
local function startInfiniteZoom()
    task.spawn(function()
        while infiniteZoom do
            pcall(function()
                if player:FindFirstChild("CameraMaxZoomDistance") then
                    player.CameraMaxZoomDistance = math.huge
                end
            end)
            task.wait(1)
        end
    end)
end

-- ================= FUNGSI VISUAL =================

local lightingConnection = nil

-- Fungsi Apply Permanent Lighting
local function applyPermanentLighting()
    if lightingConnection then
        lightingConnection:Disconnect()
    end
    
    lightingConnection = RunService.Heartbeat:Connect(function()
        Lighting.Brightness = brightness
        Lighting.ClockTime = timeOfDay
    end)
end

-- Fungsi Remove Fog
local function removeFog()
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

-- Fungsi 8-Bit Mode
local function enable8Bit()
    task.spawn(function()
        for _, obj in pairs(workspace:GetDescendants()) do
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
            end
            if obj:IsA("Decal") or obj:IsA("Texture") then
                obj.Transparency = 1
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
        
        workspace.DescendantAdded:Connect(function(obj)
            if obj:IsA("BasePart") then
                obj.Material = Enum.Material.SmoothPlastic
                obj.Reflectance = 0
                obj.CastShadow = false
            end
        end)
    end)
end

-- Fungsi Remove Particles
local function removeParticles()
    for _, obj in pairs(workspace:GetDescendants()) do
        if obj:IsA("ParticleEmitter") or obj:IsA("Trail") or obj:IsA("Beam") or obj:IsA("Fire") or obj:IsA("Smoke") or obj:IsA("Sparkles") then
            obj.Enabled = false
            obj:Destroy()
        end
    end
    
    workspace.DescendantAdded:Connect(function(obj)
        if obj:IsA("ParticleEmitter") or obj:IsA("Trail") or obj:IsA("Beam") or obj:IsA("Fire") or obj:IsA("Smoke") or obj:IsA("Sparkles") then
            obj.Enabled = false
            obj:Destroy()
        end
    end)
end

-- Fungsi Performance Mode
local function performanceMode()
    Lighting.GlobalShadows = false
    Lighting.FogEnd = 100000
    Lighting.FogStart = 0
    Lighting.Brightness = 1
    Lighting.OutdoorAmbient = Color3.fromRGB(128, 128, 128)
    
    for _, obj in pairs(workspace:GetDescendants()) do
        if obj:IsA("ParticleEmitter") or obj:IsA("Trail") or obj:IsA("Beam") or obj:IsA("Fire") or obj:IsA("Smoke") or obj:IsA("Sparkles") then
            obj.Enabled = false
        end
        
        if obj:IsA("Part") or obj:IsA("MeshPart") then
            obj.Material = Enum.Material.SmoothPlastic
            obj.Reflectance = 0
            obj.CastShadow = false
        end
    end
    
    settings().Rendering.QualityLevel = 1
end

-- ================= FUNGSI TELEPORT =================

-- Fungsi Teleport ke Position
local function teleportToPosition(position)
    pcall(function()
        local character = player.Character
        if character then
            local humanoidRootPart = character:FindFirstChild("HumanoidRootPart")
            if humanoidRootPart then
                humanoidRootPart.CFrame = CFrame.new(position + Vector3.new(0, 5, 0))
                return true
            end
        end
        return false
    end)
end

-- Fungsi Teleport ke Island
local function teleportToIsland(islandName)
    for _, island in ipairs(IslandsData) do
        if island.Name == islandName then
            teleportToPosition(island.Position)
            Rayfield:Notify({
                Title = "✅ Island Teleport",
                Content = "Teleported to " .. islandName,
                Duration = 3
            })
            break
        end
    end
end

-- Fungsi Teleport ke Event
local function teleportToEvent(eventName)
    pcall(function()
        local props = workspace:FindFirstChild("Props")
        if props and props:FindFirstChild(eventName) and props[eventName]:FindFirstChild("Fishing Boat") then
            local fishingBoat = props[eventName]["Fishing Boat"]
            local boatCFrame = fishingBoat:GetPivot()
            local character = player.Character
            if character then
                local humanoidRootPart = character:FindFirstChild("HumanoidRootPart")
                if humanoidRootPart then
                    humanoidRootPart.CFrame = boatCFrame + Vector3.new(0, 15, 0)
                    Rayfield:Notify({
                        Title = "✅ Event Teleport",
                        Content = "Teleported to " .. eventName,
                        Duration = 3
                    })
                end
            end
        else
            Rayfield:Notify({
                Title = "❌ Event Not Found",
                Content = eventName .. " event is not active!",
                Duration = 3
            })
        end
    end)
end

-- Fungsi Teleport ke Player
local function teleportToPlayer(playerName)
    pcall(function()
        local targetPlayer = Players:FindFirstChild(playerName)
        if targetPlayer and targetPlayer.Character then
            local targetHRP = targetPlayer.Character:FindFirstChild("HumanoidRootPart")
            local character = player.Character
            if targetHRP and character then
                local humanoidRootPart = character:FindFirstChild("HumanoidRootPart")
                if humanoidRootPart then
                    humanoidRootPart.CFrame = targetHRP.CFrame + Vector3.new(0, 3, 0)
                    Rayfield:Notify({
                        Title = "✅ Player Teleport",
                        Content = "Teleported to " .. playerName,
                        Duration = 3
                    })
                end
            end
        else
            Rayfield:Notify({
                Title = "❌ Player Not Found",
                Content = "Player " .. playerName .. " not found!",
                Duration = 3
            })
        end
    end)
end

-- Fungsi Server Hop
local function serverHop()
    pcall(function()
        local placeId = game.PlaceId
        local servers = {}
        local cursor = ""

        repeat
            local url = "https://games.roblox.com/v1/games/"..placeId.."/servers/Public?sortOrder=Asc&limit=100"
            if cursor ~= "" then
                url = url .. "&cursor=" .. cursor
            end

            local success, result = pcall(function()
                return HttpService:JSONDecode(game:HttpGet(url))
            end)

            if success and result and result.data then
                for _, server in pairs(result.data) do
                    if server.playing < server.maxPlayers and server.id ~= game.JobId then
                        table.insert(servers, server.id)
                    end
                end
                cursor = result.nextPageCursor or ""
            else
                break
            end
        until not cursor or #servers > 0

        if #servers > 0 then
            local targetServer = servers[math.random(1, #servers)]
            TeleportService:TeleportToPlaceInstance(placeId, targetServer, player)
            Rayfield:Notify({
                Title = "🔄 Server Hop",
                Content = "Joining new server...",
                Duration = 3
            })
        else
            Rayfield:Notify({
                Title = "❌ Server Hop Failed",
                Content = "No servers available or all are full!",
                Duration = 3
            })
        end
    end)
end

-- ================= FUNGSI AUTO SELL =================

-- Fungsi Auto Sell
local function startAutoSell()
    task.spawn(function()
        while autoSell do
            pcall(function()
                -- Cek apakah Replion tersedia
                if not Replion then 
                    task.wait(10)
                    return 
                end
                
                local DataReplion = Replion.Client:WaitReplion("Data")
                local items = DataReplion and DataReplion:Get({"Inventory","Items"})
                if type(items) ~= "table" then return end

                -- Hitung ikan yang tidak difavoritkan
                local unfavoritedCount = 0
                for _, item in ipairs(items) do
                    if not item.Favorited then
                        unfavoritedCount = unfavoritedCount + (item.Count or 1)
                    end
                end

                -- Jual hanya jika melebihi threshold dan delay terpenuhi
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
            task.wait(10) -- Cek setiap 10 detik
        end
    end)
end

-- Fungsi mendapatkan net folder
local function getNetFolder() 
    return net 
end

-- ================= FUNGSI AUTO FISH =================

-- Fungsi utama auto fish
local function AutoFishCycle()
    pcall(function()
        -- Equip rod
        equipRemote:FireServer(1)
        task.wait(0.1)

        -- Charge rod
        local timestamp = perfectCast and 9999999999 or (tick() + math.random())
        rodRemote:InvokeServer(timestamp)
        task.wait(0.5)

        -- Perfect / random cast
        local x = perfectCast and -1.238 or (math.random(-1000,1000)/1000)
        local y = perfectCast and 0.969 or (math.random(0,1000)/1000)
        miniGameRemote:InvokeServer(x, y)

        -- Event-based detection
        local caught = false
        -- Misal rod punya nilai "HasFish" atau bisa juga detect via folder di player
        local rodTool = player.Backpack:FindFirstChild("FishingRod") or player.Character:FindFirstChild("FishingRod")
        if rodTool then
            local connection
            connection = rodTool:GetAttributeChangedSignal("HasFish"):Connect(function()
                if rodTool:GetAttribute("HasFish") == true then
                    caught = true
                    connection:Disconnect()
                end
            end)
            -- Safety fallback
            local timer = 0
            while not caught and timer < 15 do
                task.wait(0.1)
                timer += 0.1
            end
        else
            task.wait(5) -- fallback jika rod tidak ketemu
        end

        -- Fire finishRemote dua kali
        finishRemote:FireServer()
        task.wait(0.1)
        finishRemote:FireServer()

        fishCount += 1
        CounterLabel:Set("🐟 Fish Caught: " .. fishCount)
    end)
end

-- ================= TAB UTILITY =================

local UtilitySection = UtilityTab:CreateSection("🛠️ Utility Features")

UtilityTab:CreateToggle({
    Name = "🛡️ Anti AFK",
    CurrentValue = antiAFK,
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

UtilityTab:CreateToggle({
    Name = "🦘 Auto Jump",
    CurrentValue = autoJump,
    Callback = function(val)
        autoJump = val
        if val then
            startAutoJump()
            Rayfield:Notify({
                Title = "✅ Auto Jump Enabled",
                Content = "Auto jumping with " .. autoJumpDelay .. "s delay",
                Duration = 4
            })
        else
            Rayfield:Notify({
                Title = "❌ Auto Jump Disabled",
                Content = "Auto jumping turned off",
                Duration = 3
            })
        end
    end
})

UtilityTab:CreateSlider({
    Name = "⏱️ Jump Delay (seconds)",
    Range = {1, 10},
    Increment = 0.5,
    CurrentValue = autoJumpDelay,
    Callback = function(val)
        autoJumpDelay = val
    end
})

UtilityTab:CreateToggle({
    Name = "🌊 Walk on Water",
    CurrentValue = walkOnWater,
    Callback = function(val)
        walkOnWater = val
        if val then
            startWalkOnWater()
            Rayfield:Notify({
                Title = "✅ Walk on Water Enabled",
                Content = "You can now walk on water!",
                Duration = 4
            })
        else
            Rayfield:Notify({
                Title = "❌ Walk on Water Disabled",
                Content = "Water walking turned off",
                Duration = 3
            })
        end
    end
})

UtilityTab:CreateToggle({
    Name = "🚷 NoClip",
    CurrentValue = noClip,
    Callback = function(val)
        noClip = val
        if val then
            startNoClip()
            Rayfield:Notify({
                Title = "✅ NoClip Enabled",
                Content = "No collision mode activated",
                Duration = 4
            })
        else
            Rayfield:Notify({
                Title = "❌ NoClip Disabled",
                Content = "Collision mode restored",
                Duration = 3
            })
        end
    end
})

UtilityTab:CreateToggle({
    Name = "👁️ XRay Vision",
    CurrentValue = xRay,
    Callback = function(val)
        xRay = val
        if val then
            startXRay()
            Rayfield:Notify({
                Title = "✅ XRay Enabled",
                Content = "See through walls activated",
                Duration = 4
            })
        else
            Rayfield:Notify({
                Title = "❌ XRay Disabled",
                Content = "Normal vision restored",
                Duration = 3
            })
        end
    end
})

UtilityTab:CreateToggle({
    Name = "🎯 Player ESP",
    CurrentValue = espEnabled,
    Callback = function(val)
        espEnabled = val
        if val then
            startESP()
            Rayfield:Notify({
                Title = "✅ ESP Enabled",
                Content = "Player ESP activated",
                Duration = 4
            })
        else
            Rayfield:Notify({
                Title = "❌ ESP Disabled",
                Content = "Player ESP turned off",
                Duration = 3
            })
        end
    end
})

UtilityTab:CreateSlider({
    Name = "📏 ESP Distance",
    Range = {10, 100},
    Increment = 5,
    CurrentValue = espDistance,
    Callback = function(val)
        espDistance = val
    end
})

-- ================= TAB TELEPORT =================

local IslandSection = TeleportTab:CreateSection("🏝️ Island Teleport")

-- Get island names for dropdown
local islandNames = {}
for _, island in ipairs(IslandsData) do
    table.insert(islandNames, island.Name)
end

local IslandDropdown = TeleportTab:CreateDropdown({
    Name = "Select Island",
    Options = islandNames,
    CurrentOption = islandNames[1],
    Callback = function(Option) end
})

TeleportTab:CreateButton({
    Name = "📌 Teleport to Selected Island",
    Callback = function()
        local selectedIsland = IslandDropdown.CurrentOption
        teleportToIsland(selectedIsland)
    end
})

local EventSection = TeleportTab:CreateSection("⚡ Event Teleport")

local EventDropdown = TeleportTab:CreateDropdown({
    Name = "Select Event",
    Options = eventsList,
    CurrentOption = eventsList[1],
    Callback = function(Option) end
})

TeleportTab:CreateButton({
    Name = "🎯 Teleport to Selected Event",
    Callback = function()
        local selectedEvent = EventDropdown.CurrentOption
        teleportToEvent(selectedEvent)
    end
})

local PlayerSection = TeleportTab:CreateSection("👥 Player Teleport")

-- Get player list
local playerList = {}
for _, plr in ipairs(Players:GetPlayers()) do
    if plr ~= player then
        table.insert(playerList, plr.Name)
    end
end

if #playerList == 0 then
    table.insert(playerList, "No other players")
end

local PlayerDropdown = TeleportTab:CreateDropdown({
    Name = "Select Player",
    Options = playerList,
    CurrentOption = playerList[1],
    Callback = function(Option) end
})

TeleportTab:CreateButton({
    Name = "🔄 Refresh Player List",
    Callback = function()
        local newPlayerList = {}
        for _, plr in ipairs(Players:GetPlayers()) do
            if plr ~= player then
                table.insert(newPlayerList, plr.Name)
            end
        end
        
        if #newPlayerList == 0 then
            table.insert(newPlayerList, "No other players")
        end
        
        PlayerDropdown:Refresh(newPlayerList, true)
        Rayfield:Notify({
            Title = "✅ Player List Updated",
            Content = "Refreshed player list",
            Duration = 2
        })
    end
})

TeleportTab:CreateButton({
    Name = "👤 Teleport to Selected Player",
    Callback = function()
        local selectedPlayer = PlayerDropdown.CurrentOption
        if selectedPlayer ~= "No other players" then
            teleportToPlayer(selectedPlayer)
        else
            Rayfield:Notify({
                Title = "❌ No Players",
                Content = "No other players to teleport to!",
                Duration = 3
            })
        end
    end
})

local PositionSection = TeleportTab:CreateSection("📍 Position Management")

local savedPosition = nil
local checkpointPosition = nil

TeleportTab:CreateButton({
    Name = "💾 Save Current Position",
    Callback = function()
        local character = player.Character
        if character and character:FindFirstChild("HumanoidRootPart") then
            savedPosition = character.HumanoidRootPart.CFrame
            Rayfield:Notify({
                Title = "✅ Position Saved",
                Content = "Current position saved",
                Duration = 2
            })
        end
    end
})

TeleportTab:CreateButton({
    Name = "🚀 Teleport to Saved Position",
    Callback = function()
        if savedPosition then
            local character = player.Character
            if character and character:FindFirstChild("HumanoidRootPart") then
                character.HumanoidRootPart.CFrame = savedPosition
                Rayfield:Notify({
                    Title = "✅ Position Loaded",
                    Content = "Teleported to saved position",
                    Duration = 2
                })
            end
        else
            Rayfield:Notify({
                Title = "❌ No Saved Position",
                Content = "Save a position first!",
                Duration = 3
            })
        end
    end
})

TeleportTab:CreateButton({
    Name = "📌 Set Checkpoint",
    Callback = function()
        local character = player.Character
        if character and character:FindFirstChild("HumanoidRootPart") then
            checkpointPosition = character.HumanoidRootPart.CFrame
            Rayfield:Notify({
                Title = "✅ Checkpoint Set",
                Content = "Checkpoint position saved",
                Duration = 2
            })
        end
    end
})

TeleportTab:CreateButton({
    Name = "↩️ Teleport to Checkpoint",
    Callback = function()
        if checkpointPosition then
            local character = player.Character
            if character and character:FindFirstChild("HumanoidRootPart") then
                character.HumanoidRootPart.CFrame = checkpointPosition
                Rayfield:Notify({
                    Title = "✅ Checkpoint Loaded",
                    Content = "Teleported to checkpoint",
                    Duration = 2
                })
            end
        else
            Rayfield:Notify({
                Title = "❌ No Checkpoint",
                Content = "Set a checkpoint first!",
                Duration = 3
            })
        end
    end
})

TeleportTab:CreateToggle({
    Name = "🔒 Lock Position",
    CurrentValue = lockedPosition,
    Callback = function(val)
        lockedPosition = val
        if val then
            local character = player.Character
            if character and character:FindFirstChild("HumanoidRootPart") then
                lockCFrame = character.HumanoidRootPart.CFrame
                startLockPosition()
                Rayfield:Notify({
                    Title = "✅ Position Locked",
                    Content = "Position locked in place",
                    Duration = 3
                })
            end
        else
            Rayfield:Notify({
                Title = "❌ Position Unlocked",
                Content = "Position lock released",
                Duration = 3
            })
        end
    end
})

-- ================= TAB VISUAL =================

local LightingSection = VisualTab:CreateSection("💡 Lighting & Graphics")

VisualTab:CreateButton({
    Name = "☀️ Fullbright",
    Callback = function()
        brightness = 3
        timeOfDay = 14
        Lighting.Brightness = 3
        Lighting.ClockTime = 14
        Lighting.FogEnd = 100000
        Lighting.GlobalShadows = false
        applyPermanentLighting()
        Rayfield:Notify({
            Title = "✅ Fullbright Enabled",
            Content = "Maximum brightness activated",
            Duration = 3
        })
    end
})

VisualTab:CreateButton({
    Name = "🌫️ Remove Fog",
    Callback = function()
        removeFog()
        Rayfield:Notify({
            Title = "✅ Fog Removed",
            Content = "Fog disabled permanently",
            Duration = 3
        })
    end
})

VisualTab:CreateButton({
    Name = "🎮 8-Bit Mode",
    Callback = function()
        enable8Bit()
        Rayfield:Notify({
            Title = "✅ 8-Bit Mode",
            Content = "Super smooth rendering enabled",
            Duration = 3
        })
    end
})

VisualTab:CreateButton({
    Name = "✨ Remove Particles",
    Callback = function()
        removeParticles()
        Rayfield:Notify({
            Title = "✅ Particles Removed",
            Content = "All effects disabled",
            Duration = 3
        })
    end
})

VisualTab:CreateButton({
    Name = "🚀 Performance Mode",
    Callback = function()
        performanceMode()
        Rayfield:Notify({
            Title = "✅ Performance Mode",
            Content = "Ultra performance activated",
            Duration = 3
        })
    end
})

VisualTab:CreateSlider({
    Name = "💡 Brightness",
    Range = {0, 10},
    Increment = 0.5,
    CurrentValue = brightness,
    Callback = function(val)
        brightness = val
        Lighting.Brightness = val
        applyPermanentLighting()
    end
})

VisualTab:CreateSlider({
    Name = "⏰ Time of Day",
    Range = {0, 24},
    Increment = 0.5,
    CurrentValue = timeOfDay,
    Callback = function(val)
        timeOfDay = val
        Lighting.ClockTime = val
        applyPermanentLighting()
    end
})

VisualTab:CreateToggle({
    Name = "🔍 Infinite Zoom",
    CurrentValue = infiniteZoom,
    Callback = function(val)
        infiniteZoom = val
        if val then
            startInfiniteZoom()
            Rayfield:Notify({
                Title = "✅ Infinite Zoom",
                Content = "Zoom limits removed",
                Duration = 3
            })
        else
            Rayfield:Notify({
                Title = "❌ Zoom Limited",
                Content = "Normal zoom restored",
                Duration = 3
            })
        end
    end
})

VisualTab:CreateButton({
    Name = "📷 Remove Camera Shake",
    Callback = function()
        local cam = workspace.CurrentCamera
        if cam then
            cam.FieldOfView = 70
        end
        Rayfield:Notify({
            Title = "✅ Camera Fixed",
            Content = "Camera shake removed",
            Duration = 2
        })
    end
})

-- ================= TAB SERVER =================

local ServerSection = ServerTab:CreateSection("🌐 Server Management")

ServerTab:CreateToggle({
    Name = "🔄 Auto Rejoin",
    CurrentValue = autoRejoin,
    Callback = function(val)
        autoRejoin = val
        if val then
            Rayfield:Notify({
                Title = "✅ Auto Rejoin Enabled",
                Content = "Will auto rejoin on disconnect",
                Duration = 3
            })
        else
            Rayfield:Notify({
                Title = "❌ Auto Rejoin Disabled",
                Content = "Auto rejoin turned off",
                Duration = 3
            })
        end
    end
})

ServerTab:CreateButton({
    Name = "🔄 Rejoin Server",
    Callback = function()
        TeleportService:Teleport(game.PlaceId, player)
        Rayfield:Notify({
            Title = "🔄 Rejoining",
            Content = "Rejoining current server...",
            Duration = 3
        })
    end
})

ServerTab:CreateButton({
    Name = "🚀 Server Hop",
    Callback = function()
        serverHop()
    end
})

ServerTab:CreateButton({
    Name = "📋 Copy Job ID",
    Callback = function()
        pcall(function()
            setclipboard(game.JobId)
            Rayfield:Notify({
                Title = "✅ Copied",
                Content = "Job ID copied to clipboard!",
                Duration = 2
            })
        end)
    end
})

ServerTab:CreateButton({
    Name = "📊 Show Server Stats",
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
            player:GetNetworkPing() * 1000,
            workspace:GetRealPhysicsFPS(),
            game.JobId
        )
        print(stats)
        Rayfield:Notify({
            Title = "📊 Server Stats",
            Content = "Check console (F9) for details",
            Duration = 3
        })
    end
})

-- ================= TAB MAIN CONTROLS =================

-- START / STOP AUTO FISH
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
        end
    end
})

-- PERFECT CAST OPTION
MainTab:CreateToggle({
    Name = "✨ Use Perfect Cast",
    CurrentValue = false,
    Callback = function(val)
        perfectCast = val
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

-- DELAY SLIDER
MainTab:CreateSlider({
    Name = "⏱️ Auto Recast Delay (seconds)",
    Range = {0.5, 5},
    Increment = 0.1,
    CurrentValue = autoRecastDelay,
    Callback = function(val)
        autoRecastDelay = val
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

-- CLOSE GUI BUTTON
MainTab:CreateButton({
    Name = "❌ Close GUI",
    Callback = function()
        Rayfield:Destroy()
    end
})

-- Notifikasi awal
Rayfield:Notify({
    Title = "✅ AutoFish GUI Loaded",
    Content = "All features loaded! Auto Fishing, Utility, Teleport, Visual & Server systems ready!",
    Duration = 4
})
