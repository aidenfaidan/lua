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
local TweenService = game:GetService("TweenService")

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

-- Data Teleport - Diperbarui dengan posisi yang lebih akurat
local IslandsData = {
    {Name = "Fisherman Island", Position = Vector3.new(92, 9, 2768)},
    {Name = "Arrow Lever", Position = Vector3.new(898, 8, -363)},
    {Name = "Sisyphus Statue", Position = Vector3.new(-3740, -136, -1013)},
    {Name = "Ancient Jungle", Position = Vector3.new(1481, 11, -302)},
    {Name = "Weather Machine", Position = Vector3.new(-1519, 2, 1908)},
    {Name = "Coral Reefs", Position = Vector3.new(-3105, 6, 2218)},
    {Name = "Tropical Island", Position = Vector3.new(-2110, 53, 3649)},
    {Name = "Kohana", Position = Vector3.new(-662, 3, 714)},
    {Name = "Esoteric Island", Position = Vector3.new(2035, 27, 1386)},
    {Name = "Diamond Lever", Position = Vector3.new(1818, 8, -285)},
    {Name = "Underground Cellar", Position = Vector3.new(2098, -92, -703)},
    {Name = "Volcano", Position = Vector3.new(-631, 54, 194)},
    {Name = "Enchant Room", Position = Vector3.new(3255, -1302, 1371)},
    {Name = "Lost Isle", Position = Vector3.new(-3717, 5, -1079)},
    {Name = "Sacred Temple", Position = Vector3.new(1475, -22, -630)},
    {Name = "Crater Island", Position = Vector3.new(981, 41, 5080)},
    {Name = "Double Enchant Room", Position = Vector3.new(1480, 127, -590)},
    {Name = "Treasure Room", Position = Vector3.new(-3599, -276, -1642)},
    {Name = "Crescent Lever", Position = Vector3.new(1419, 31, 78)},
    {Name = "Hourglass Diamond Lever", Position = Vector3.new(1484, 8, -862)},
    {Name = "Snow Island", Position = Vector3.new(1627, 4, 3288)}
}

-- Data Events dengan posisi alternatif
local eventsList = {
    "Shark Hunt", 
    "Ghost Shark Hunt", 
    "Worm Hunt", 
    "Black Hole", 
    "Shocked", 
    "Ghost Worm", 
    "Meteor Rain"
}

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

-- ================= FUNGSI TELEPORT YANG DIPERBAIKI =================

-- Fungsi Teleport ke Position yang lebih reliable
local function TeleportToPosition(position)
    local success, err = pcall(function()
        local character = player.Character
        if not character then
            character = player.CharacterAdded:Wait()
        end
        
        local humanoidRootPart = character:WaitForChild("HumanoidRootPart")
        
        -- Gunakan TweenService untuk teleport yang lebih smooth
        local tweenInfo = TweenInfo.new(1, Enum.EasingStyle.Linear)
        local tween = TweenService:Create(humanoidRootPart, tweenInfo, {CFrame = CFrame.new(position + Vector3.new(0, 5, 0))})
        tween:Play()
        
        tween.Completed:Wait()
        return true
    end)
    
    if not success then
        warn("[Teleport Error]: " .. tostring(err))
        -- Fallback ke metode biasa
        pcall(function()
            local character = player.Character
            if character and character:FindFirstChild("HumanoidRootPart") then
                character.HumanoidRootPart.CFrame = CFrame.new(position + Vector3.new(0, 5, 0))
            end
        end)
    end
    
    return success
end

-- Fungsi Teleport ke Island yang diperbaiki
local function TeleportToIsland(islandName)
    local success = false
    local islandFound = false
    
    for _, island in ipairs(IslandsData) do
        if island.Name == islandName then
            islandFound = true
            Rayfield:Notify({
                Title = "🚀 Teleporting...",
                Content = "Teleporting to " .. islandName,
                Duration = 2
            })
            
            -- Tunggu sedikit sebelum teleport
            task.wait(1)
            
            success = TeleportToPosition(island.Position)
            
            if success then
                Rayfield:Notify({
                    Title = "✅ Teleport Success",
                    Content = "Successfully teleported to " .. islandName,
                    Duration = 3
                })
            else
                Rayfield:Notify({
                    Title = "❌ Teleport Failed",
                    Content = "Failed to teleport to " .. islandName,
                    Duration = 3
                })
            end
            break
        end
    end
    
    if not islandFound then
        Rayfield:Notify({
            Title = "❌ Island Not Found",
            Content = "Island '" .. islandName .. "' not found in database",
            Duration = 3
        })
    end
    
    return success
end

-- Fungsi Scan Events yang lebih akurat
local function ScanActiveEvents()
    local events = {}
    local validEvents = {
        "Shark", "Ghost", "Worm", "Black Hole", "Shocked", "Meteor"
    }

    -- Cari di workspace untuk event objects
    for _, obj in pairs(workspace:GetDescendants()) do
        if obj:IsA("Model") then
            local name = obj.Name
            for _, eventKeyword in ipairs(validEvents) do
                if string.find(name, eventKeyword) then
                    local exists = false
                    for _, e in ipairs(events) do
                        if e.Name == name then
                            exists = true
                            break
                        end
                    end
                    
                    if not exists then
                        local pos = Vector3.new(0, 0, 0)
                        if obj.PrimaryPart then
                            pos = obj.PrimaryPart.Position
                        elseif obj:FindFirstChild("HumanoidRootPart") then
                            pos = obj.HumanoidRootPart.Position
                        else
                            -- Coba dapatkan posisi dari part pertama
                            for _, part in pairs(obj:GetChildren()) do
                                if part:IsA("BasePart") then
                                    pos = part.Position
                                    break
                                end
                            end
                        end
                        
                        table.insert(events, {
                            Name = name,
                            Object = obj,
                            Position = pos
                        })
                    end
                    break
                end
            end
        end
    end

    print("[EVENT SCANNER] Found " .. tostring(#events) .. " events.")
    return events
end

-- Fungsi Teleport ke Event yang diperbaiki
local function TeleportToEvent(eventName)
    Rayfield:Notify({
        Title = "🔍 Scanning Events...",
        Content = "Looking for " .. eventName,
        Duration = 2
    })
    
    local events = ScanActiveEvents()
    local eventFound = false
    local success = false
    
    for _, event in ipairs(events) do
        if string.find(event.Name, eventName) or string.find(eventName, event.Name) then
            eventFound = true
            Rayfield:Notify({
                Title = "🎯 Event Found",
                Content = "Teleporting to " .. event.Name,
                Duration = 2
            })
            
            task.wait(1)
            success = TeleportToPosition(event.Position)
            
            if success then
                Rayfield:Notify({
                    Title = "✅ Event Teleport Success",
                    Content = "Teleported to " .. event.Name,
                    Duration = 3
                })
            else
                Rayfield:Notify({
                    Title = "❌ Event Teleport Failed",
                    Content = "Failed to teleport to " .. event.Name,
                    Duration = 3
                })
            end
            break
        end
    end
    
    if not eventFound then
        -- Fallback: Coba cari di Props folder
        local props = workspace:FindFirstChild("Props")
        if props then
            for _, prop in pairs(props:GetChildren()) do
                if string.find(prop.Name, eventName) then
                    eventFound = true
                    local pos = Vector3.new(0, 0, 0)
                    if prop:FindFirstChild("Fishing Boat") then
                        pos = prop["Fishing Boat"].Position
                    elseif prop.PrimaryPart then
                        pos = prop.PrimaryPart.Position
                    end
                    
                    success = TeleportToPosition(pos)
                    
                    if success then
                        Rayfield:Notify({
                            Title = "✅ Event Teleport Success",
                            Content = "Teleported to " .. prop.Name,
                            Duration = 3
                        })
                    end
                    break
                end
            end
        end
        
        if not eventFound then
            Rayfield:Notify({
                Title = "❌ Event Not Active",
                Content = eventName .. " event is not currently active",
                Duration = 3
            })
        end
    end
    
    return success
end

-- Fungsi Teleport ke Player yang diperbaiki
local function TeleportToPlayer(playerName)
    local success, err = pcall(function()
        local targetPlayer = Players:FindFirstChild(playerName)
        if not targetPlayer then
            error("Player not found: " .. playerName)
        end
        
        local targetCharacter = targetPlayer.Character
        if not targetCharacter then
            error("Player character not found")
        end
        
        local targetHRP = targetCharacter:WaitForChild("HumanoidRootPart")
        local character = player.Character
        if not character then
            character = player.CharacterAdded:Wait()
        end
        
        local humanoidRootPart = character:WaitForChild("HumanoidRootPart")
        
        -- Gunakan TweenService untuk teleport yang lebih smooth
        local tweenInfo = TweenInfo.new(1, Enum.EasingStyle.Linear)
        local tween = TweenService:Create(humanoidRootPart, tweenInfo, {CFrame = targetHRP.CFrame + Vector3.new(0, 3, 0)})
        tween:Play()
        
        tween.Completed:Wait()
        return true
    end)
    
    if success then
        Rayfield:Notify({
            Title = "✅ Player Teleport",
            Content = "Teleported to " .. playerName,
            Duration = 3
        })
    else
        Rayfield:Notify({
            Title = "❌ Teleport Failed",
            Content = "Failed to teleport: " .. tostring(err),
            Duration = 3
        })
    end
    
    return success
end

-- ================= TAB TELEPORT YANG DIPERBAIKI =================

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
        TeleportToIsland(selectedIsland)
    end
})

-- Button untuk test teleport ke island tertentu
TeleportTab:CreateButton({
    Name = "🏝️ Test Fisherman Island",
    Callback = function()
        TeleportToIsland("Fisherman Island")
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
        TeleportToEvent(selectedEvent)
    end
})

-- Button untuk scan events manual
TeleportTab:CreateButton({
    Name = "🔍 Scan Active Events",
    Callback = function()
        local events = ScanActiveEvents()
        if #events > 0 then
            local eventNames = {}
            for _, event in ipairs(events) do
                table.insert(eventNames, event.Name)
            end
            Rayfield:Notify({
                Title = "📊 Active Events Found",
                Content = "Events: " .. table.concat(eventNames, ", "),
                Duration = 5
            })
        else
            Rayfield:Notify({
                Title = "❌ No Events",
                Content = "No active events found",
                Duration = 3
            })
        end
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
            Content = "Found " .. (#newPlayerList) .. " players",
            Duration = 2
        })
    end
})

TeleportTab:CreateButton({
    Name = "👤 Teleport to Selected Player",
    Callback = function()
        local selectedPlayer = PlayerDropdown.CurrentOption
        if selectedPlayer ~= "No other players" then
            TeleportToPlayer(selectedPlayer)
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

-- Fungsi save position yang diperbaiki
local function SaveCurrentPosition()
    local character = player.Character
    if character and character:FindFirstChild("HumanoidRootPart") then
        savedPosition = character.HumanoidRootPart.CFrame
        Rayfield:Notify({
            Title = "✅ Position Saved",
            Content = "Current position saved successfully",
            Duration = 2
        })
        return true
    else
        Rayfield:Notify({
            Title = "❌ Save Failed",
            Content = "Could not save position - character not found",
            Duration = 3
        })
        return false
    end
end

-- Fungsi teleport to saved position yang diperbaiki
local function TeleportToSavedPosition()
    if savedPosition then
        local success = TeleportToPosition(savedPosition.Position)
        if success then
            Rayfield:Notify({
                Title = "✅ Position Loaded",
                Content = "Teleported to saved position",
                Duration = 2
            })
        else
            Rayfield:Notify({
                Title = "❌ Teleport Failed",
                Content = "Failed to teleport to saved position",
                Duration = 3
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

TeleportTab:CreateButton({
    Name = "💾 Save Current Position",
    Callback = SaveCurrentPosition
})

TeleportTab:CreateButton({
    Name = "🚀 Teleport to Saved Position",
    Callback = TeleportToSavedPosition
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
            local success = TeleportToPosition(checkpointPosition.Position)
            if success then
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
                -- Start lock position loop
                task.spawn(function()
                    while lockedPosition do
                        if character and character:FindFirstChild("HumanoidRootPart") then
                            character.HumanoidRootPart.CFrame = lockCFrame
                        end
                        task.wait()
                    end
                end)
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

-- ... (Fungsi dan tab lainnya tetap sama seperti sebelumnya)

-- Notifikasi awal
Rayfield:Notify({
    Title = "✅ AutoFish GUI Loaded",
    Content = "All features loaded! Teleport system IMPROVED with better detection!",
    Duration = 5
})

print("=== TELEPORT SYSTEM READY ===")
print("Island Teleport: " .. #IslandsData .. " locations available")
print("Event Teleport: " .. #eventsList .. " event types")
print("Player Teleport: Ready")
print("Position Management: Ready")
