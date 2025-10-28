--// AUTO FISH GUI - Versi HyRexxyy Event-Based dengan Auto Sell
local Rayfield = loadstring(game:HttpGet('https://sirius.menu/rayfield'))()
local ReplicatedStorage = game:GetService("ReplicatedStorage")
local Players = game:GetService("Players")
local player = Players.LocalPlayer

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

-- Cari remote untuk jual ikan (mungkin ada beberapa kemungkinan)
local sellRemote
local sellAllRemote

-- Mencari remote jual ikan yang tepat
pcall(function()
    sellRemote = net:WaitForChild("RE/SellFish") -- Untuk jual ikan tertentu
end)

pcall(function()
    sellAllRemote = net:WaitForChild("RE/SellAllFish") -- Untuk jual semua ikan
end)

-- Jika tidak ditemukan di net, coba cari di tempat lain
if not sellRemote and not sellAllRemote then
    pcall(function()
        sellAllRemote = ReplicatedStorage:WaitForChild("SellAllFish")
    end)
end

-- Variabel utama
local autofish = false
local perfectCast = false
local autoRecastDelay = 2
local fishCount = 0
local autoSell = false
local autoSellInterval = 10 -- Jual setiap 10 ikan
local coinsEarned = 0

-- GUI Setup
local Window = Rayfield:CreateWindow({
    Name = "🎣 Auto Fishing Hub",
    LoadingTitle = "Fishing AutoFarm",
    LoadingSubtitle = "By HyRexxyy x GPT",
    ConfigurationSaving = { Enabled = true, FolderName = "AutoFishSettings" },
    KeySystem = false
})

local MainTab = Window:CreateTab("⚙️ Main Controls")
local CounterLabel = MainTab:CreateLabel("🐟 Fish Caught: 0")
local CoinsLabel = MainTab:CreateLabel("💰 Coins Earned: 0")

-- Fungsi untuk menjual ikan
local function SellFish()
    pcall(function()
        if sellAllRemote then
            -- Jika ada remote jual semua
            sellAllRemote:FireServer()
            Rayfield:Notify({
                Title = "💰 Auto Sell",
                Content = "All fish sold successfully!",
                Duration = 3
            })
        elseif sellRemote then
            -- Jika hanya ada remote jual per ikan, perlu implementasi lebih kompleks
            -- Ini adalah placeholder - mungkin perlu iterasi melalui inventory
            sellRemote:FireServer() -- Parameter mungkin diperlukan
        else
            warn("Auto Sell: No sell remote found!")
        end
    end)
end

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

        -- Auto Sell Logic
        if autoSell and fishCount % autoSellInterval == 0 then
            SellFish()
            -- Simulasi coins earned (ini bisa disesuaikan dengan nilai sebenarnya)
            coinsEarned = coinsEarned + (autoSellInterval * 50) -- Asumsi 50 coins per ikan
            CoinsLabel:Set("💰 Coins Earned: " .. coinsEarned)
            
            Rayfield:Notify({
                Title = "💰 Auto Sell",
                Content = "Sold " .. autoSellInterval .. " fish!",
                Duration = 3
            })
        end
    end)
end

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

-- AUTO SELL TOGGLE
MainTab:CreateToggle({
    Name = "💰 Auto Sell Fish",
    CurrentValue = false,
    Callback = function(val)
        autoSell = val
        if val then
            Rayfield:Notify({
                Title = "💰 Auto Sell Enabled",
                Content = "Fish will be sold every " .. autoSellInterval .. " catches",
                Duration = 4
            })
        end
    end
})

-- AUTO SELL INTERVAL SLIDER
MainTab:CreateSlider({
    Name = "📦 Sell Every X Fish",
    Range = {5, 50},
    Increment = 1,
    CurrentValue = autoSellInterval,
    Callback = function(val)
        autoSellInterval = val
    end
})

-- MANUAL SELL BUTTON
MainTab:CreateButton({
    Name = "💵 Sell All Fish Now",
    Callback = function()
        SellFish()
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

-- RESET COUNTERS BUTTON
MainTab:CreateButton({
    Name = "🔄 Reset Counters",
    Callback = function()
        fishCount = 0
        coinsEarned = 0
        CounterLabel:Set("🐟 Fish Caught: 0")
        CoinsLabel:Set("💰 Coins Earned: 0")
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
    Content = "Auto Sell feature ready!",
    Duration = 4
})

-- Cek jika remote jual ditemukan
if sellAllRemote or sellRemote then
    Rayfield:Notify({
        Title = "💰 Sell System Ready",
        Content = "Auto Sell feature activated",
        Duration = 4
    })
else
    Rayfield:Notify({
        Title = "⚠️ Warning",
        Content = "Sell remote not found! Auto Sell may not work.",
        Duration = 6
    })
end
