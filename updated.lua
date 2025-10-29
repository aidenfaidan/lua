--// AUTO FISH GUI - Versi HyRexxyy Event-Based
local Rayfield = loadstring(game:HttpGet('https://sirius.menu/rayfield'))()
local ReplicatedStorage = game:GetService("ReplicatedStorage")
local Players = game:GetService("Players")
local player = Players.LocalPlayer
local TeleportService = game:GetService("TeleportService")

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

-- Konfigurasi Auto Sell
local AUTO_SELL_THRESHOLD = 60 -- Jual ketika ikan non-favorit > 60
local AUTO_SELL_DELAY = 60 -- Delay minimum antara penjualan (detik)

-- Data Teleport dari script kedua
local Locations = {
    ["Coral Reefs"] = Vector3.new(-2945, 66, 2248),
    ["Kohana"] = Vector3.new(-645, 16, 606),
    ["Weather Machine"] = Vector3.new(-1535, 2, 1917),
    ["Lost Isle [Sisypuhus]"] = Vector3.new(-3703, -136, -1019),
    ["Winter Fest"] = Vector3.new(1616, 4, 3280),
    ["Esoteric Depths"] = Vector3.new(3214, -1303, 1411),
    ["Tropical Grove"] = Vector3.new(-2047, 6, 3662),
    ["Stingray Shores"] = Vector3.new(2, 4, 2839),
    ["Lost Isle [Treasure Room]"] = Vector3.new(-3594, -285, -1635),
    ["Lost Isle [Lost Shore]"] = Vector3.new(-3672, 70, -912),
    ["Kohana Volcano"] = Vector3.new(-512, 24, 191),
    ["Crater Island"] = Vector3.new(1019, 20, 5071)
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
local TeleportTab = Window:CreateTab("🌍 Teleport")
local UtilityTab = Window:CreateTab("🔧 Utility")
local CounterLabel = MainTab:CreateLabel("🐟 Fish Caught: 0")

-- ================= FUNGSI TELEPORT =================

-- Fungsi Teleport ke Position
local function TeleportToPosition(position)
    pcall(function()
        local character = player.Character
        if character then
            local humanoidRootPart = character:FindFirstChild("HumanoidRootPart")
            if humanoidRootPart then
                humanoidRootPart.CFrame = CFrame.new(position)
                Rayfield:Notify({
                    Title = "✅ Teleported",
                    Content = "Successfully teleported to destination",
                    Duration = 3
                })
                return true
            end
        end
        return false
    end)
end

-- Fungsi Teleport ke Location
local function TeleportToLocation(locationName)
    if Locations[locationName] then
        TeleportToPosition(Locations[locationName])
    else
        Rayfield:Notify({
            Title = "❌ Location Not Found",
            Content = "Location '" .. locationName .. "' not found!",
            Duration = 3
        })
    end
end

-- Fungsi Teleport ke Event
local function TeleportToEvent(eventName)
    pcall(function()
        local props = workspace:FindFirstChild("Props")
        if props and props:FindFirstChild(eventName) then
            local eventObj = props[eventName]
            local pos = Vector3.new(0, 0, 0)
            
            if eventObj:FindFirstChild("Fishing Boat") then
                pos = eventObj["Fishing Boat"].Position
            elseif eventObj.PrimaryPart then
                pos = eventObj.PrimaryPart.Position
            else
                -- Cari part pertama untuk posisi
                for _, part in pairs(eventObj:GetChildren()) do
                    if part:IsA("BasePart") then
                        pos = part.Position
                        break
                    end
                end
            end
            
            TeleportToPosition(pos + Vector3.new(0, 10, 0))
            Rayfield:Notify({
                Title = "✅ Event Teleport",
                Content = "Teleported to " .. eventName,
                Duration = 3
            })
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
local function TeleportToPlayer(playerName)
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

-- Fungsi Rejoin Server
local function RejoinServer()
    pcall(function()
        TeleportService:Teleport(game.PlaceId, player)
        Rayfield:Notify({
            Title = "🔄 Rejoining",
            Content = "Rejoining current server...",
            Duration = 3
        })
    end)
end

-- ================= TAB TELEPORT =================

local IslandSection = TeleportTab:CreateSection("🏝️ Location Teleport")

-- Buat tombol untuk setiap location
for name, pos in pairs(Locations) do
    TeleportTab:CreateButton({
        Name = "📌 " .. name,
        Callback = function()
            TeleportToLocation(name)
        end
    })
end

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

local PlayerSection = TeleportTab:CreateSection("👥 Player Teleport")

-- Get player list
local playerList = {}
for _, plr in pairs(Players:GetPlayers()) do
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
        for _, plr in pairs(Players:GetPlayers()) do
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

local ServerSection = TeleportTab:CreateSection("🌐 Server Management")

TeleportTab:CreateButton({
    Name = "🔄 Rejoin Server",
    Callback = function()
        RejoinServer()
    end
})

TeleportTab:CreateButton({
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

-- ================= TAB UTILITY =================

local UtilitySection = UtilityTab:CreateSection("🛠️ Utility Features")

UtilityTab:CreateButton({
    Name = "🔄 Rejoin Server",
    Callback = function()
        RejoinServer()
    end
})

UtilityTab:CreateButton({
    Name = "🛒 Sell All Fish Now",
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
    Content = "Event-based detection ready! Auto Sell & Teleport features added!",
    Duration = 4
})
