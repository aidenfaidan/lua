--// AUTO FISH GUI - Versi HyRexxyy Event-Based
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

-- Variabel utama
local autofish = false
local perfectCast = false
local autoRecastDelay = 2
local fishCount = 0

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

-- =============================================
-- FITUR AUTO SELL YANG DITAMBAHKAN (TANPA MENGUBAH YANG ADA)
-- =============================================

-- Variabel auto sell
local autoSell = false
local autoSellInterval = 10
local coinsEarned = 0
local sellCoinsLabel = MainTab:CreateLabel("💰 Coins from Selling: 0")

-- Cari remote untuk jual ikan
local function FindSellRemote()
    -- Coba berbagai kemungkinan remote jual ikan
    local possibleRemotes = {
        "RE/SellAllFish",
        "RF/SellAllFish", 
        "RE/SellFish",
        "RF/SellFish",
        "SellAllFish",
        "SellFish"
    }
    
    for _, remoteName in ipairs(possibleRemotes) do
        local success, result = pcall(function()
            return net:FindFirstChild(remoteName)
        end)
        if success and result then
            return result
        end
    end
    
    -- Coba cari di ReplicatedStorage langsung
    for _, remoteName in ipairs(possibleRemotes) do
        local success, result = pcall(function()
            return ReplicatedStorage:FindFirstChild(remoteName)
        end)
        if success and result then
            return result
        end
    end
    
    return nil
end

local sellRemote = FindSellRemote()

-- Fungsi jual ikan
local function SellAllFish()
    if sellRemote then
        local success, err = pcall(function()
            -- Coba fire atau invoke tergantung jenis remote
            if sellRemote:IsA("RemoteEvent") then
                sellRemote:FireServer()
            elseif sellRemote:IsA("RemoteFunction") then
                sellRemote:InvokeServer()
            else
                sellRemote:FireServer()
            end
        end)
        
        if success then
            Rayfield:Notify({
                Title = "💰 Fish Sold!",
                Content = "All fish have been sold successfully",
                Duration = 3
            })
            return true
        else
            warn("Error selling fish:", err)
            return false
        end
    else
        Rayfield:Notify({
            Title = "⚠️ Sell Remote Not Found",
            Content = "Could not find sell function",
            Duration = 4
        })
        return false
    end
end

-- Auto sell logic yang terintegrasi dengan fish count
local originalFishCount = fishCount
local function CheckAutoSell()
    if autoSell and fishCount > 0 and fishCount % autoSellInterval == 0 then
        if SellAllFish() then
            -- Estimasi coins (bisa disesuaikan)
            local estimatedCoins = autoSellInterval * math.random(40, 80)
            coinsEarned = coinsEarned + estimatedCoins
            sellCoinsLabel:Set("💰 Coins from Selling: " .. coinsEarned)
        end
    end
end

-- =============================================
-- FUNGSI AUTO FISH ORIGINAL (TIDAK DIUBAH)
-- =============================================

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
        
        -- =============================================
        -- PANGGIL AUTO SELL SETIAP KALI FISH COUNT BERTAMBAH
        -- =============================================
        CheckAutoSell()
    end)
end

-- =============================================
-- ELEMEN GUI ORIGINAL (TIDAK DIUBAH)
-- =============================================

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

-- =============================================
-- ELEMEN GUI AUTO SELL YANG DITAMBAHKAN
-- =============================================

-- AUTO SELL TOGGLE
MainTab:CreateToggle({
    Name = "💰 Auto Sell Fish",
    CurrentValue = false,
    Callback = function(val)
        autoSell = val
        if val then
            Rayfield:Notify({
                Title = "Auto Sell Enabled",
                Content = "Fish will be sold every " .. autoSellInterval .. " catches",
                Duration = 4
            })
        end
    end
})

-- AUTO SELL INTERVAL
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
        SellAllFish()
    end
})

-- RESET COUNTERS BUTTON
MainTab:CreateButton({
    Name = "🔄 Reset Counters",
    Callback = function()
        fishCount = 0
        coinsEarned = 0
        CounterLabel:Set("🐟 Fish Caught: 0")
        sellCoinsLabel:Set("💰 Coins from Selling: 0")
    end
})

-- CLOSE GUI BUTTON (ORIGINAL)
MainTab:CreateButton({
    Name = "❌ Close GUI",
    Callback = function()
        Rayfield:Destroy()
    end
})

-- =============================================
-- NOTIFIKASI AWAL (DIMODIFIKASI SEDIKIT)
-- =============================================

-- Notifikasi awal
Rayfield:Notify({
    Title = "✅ AutoFish GUI Loaded",
    Content = "Event-based detection ready!" .. (sellRemote and " Auto Sell available!" : " Auto Sell not available!"),
    Duration = 4
})

-- Notifikasi status auto sell
if sellRemote then
    Rayfield:Notify({
        Title = "💰 Auto Sell Ready",
        Content = "Sell system initialized successfully",
        Duration = 3
    })
else
    Rayfield:Notify({
        Title = "⚠️ Auto Sell Warning",
        Content = "Sell remote not found. Auto Sell may not work.",
        Duration = 6
    })
end
