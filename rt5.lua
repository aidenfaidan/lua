--// AUTO FISH GUI - Versi HyRexxyy Event-Based + Nikzz Features
local Rayfield = loadstring(game:HttpGet('https://sirius.menu/rayfield'))()
local ReplicatedStorage = game:GetService("ReplicatedStorage")
local Players = game:GetService("Players")
local player = Players.LocalPlayer
local VirtualUser = game:GetService("VirtualUser")
local Workspace = game:GetService("Workspace")
local Lighting = game:GetService("Lighting")
local RunService = game:GetService("RunService")
local TweenService = game:GetService("TweenService")
local TeleportService = game:GetService("TeleportService")
local HttpService = game:GetService("HttpService")
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
local afkConnection = nil

-- Konfigurasi Auto Sell
local AUTO_SELL_THRESHOLD = 60 -- Jual ketika ikan non-favorit > 60
local AUTO_SELL_DELAY = 60 -- Delay minimum antara penjualan (detik)

-- ================= TELEGRAM SYSTEM FIXED =================

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

-- Variabel untuk fish detection system
local rareFishCount = 0
local lastFishData = nil
local fishDetectionEnabled = true

-- Fungsi HTTP request yang lebih reliable
local function sendHTTPRequest(url, method, body, headers)
    local success, result = pcall(function()
        if syn and syn.request then
            return syn.request({
                Url = url,
                Method = method,
                Headers = headers or {},
                Body = body
            })
        elseif request then
            return request({
                Url = url,
                Method = method,
                Headers = headers or {},
                Body = body
            })
        else
            return {Success = false, Body = "No HTTP client available"}
        end
    end)
    return success, result
end

-- Fungsi encode URL
local function urlEncode(str)
    if str then
        str = string.gsub(str, "([^%w _ %- . ~])", function(c)
            return string.format("%%%02X", string.byte(c))
        end)
        str = string.gsub(str, " ", "%%20")
    end
    return str
end

-- Fungsi SendTelegram yang diperbaiki
local function SendTelegram(message)
    if not TelegramConfig.Enabled then
        print("[Telegram] Hook system disabled")
        return false, "disabled"
    end
    
    if not TelegramConfig.BotToken or TelegramConfig.BotToken == "" then
        print("[Telegram] Bot token empty!")
        return false, "no token"
    end
    
    if not TelegramConfig.ChatID or TelegramConfig.ChatID == "" then
        print("[Telegram] Chat ID empty!")
        return false, "no chat id"
    end

    -- Bersihkan token dari spasi
    local cleanToken = string.gsub(TelegramConfig.BotToken, "%s+", "")
    local cleanChatID = string.gsub(TelegramConfig.ChatID, "%s+", "")
    
    -- Method 1: GET request (paling reliable)
    local encodedMessage = urlEncode(message)
    local url = string.format("https://api.telegram.org/bot%s/sendMessage?chat_id=%s&text=%s&parse_mode=Markdown", 
        cleanToken, cleanChatID, encodedMessage)
    
    local success, response = pcall(function()
        return game:HttpGet(url, true)
    end)
    
    if success then
        if string.find(response, '"ok":true') then
            print("[Telegram] ✅ Message sent successfully via GET")
            return true, response
        else
            print("[Telegram] ❌ API Error:", response)
            
            -- Method 2: POST request fallback
            local postUrl = string.format("https://api.telegram.org/bot%s/sendMessage", cleanToken)
            local payload = {
                chat_id = cleanChatID,
                text = message,
                parse_mode = "Markdown"
            }
            
            local jsonPayload = HttpService:JSONEncode(payload)
            
            local postSuccess, postResult = sendHTTPRequest(postUrl, "POST", jsonPayload, {
                ["Content-Type"] = "application/json"
            })
            
            if postSuccess and postResult and (postResult.Success or (postResult.StatusCode and postResult.StatusCode == 200)) then
                print("[Telegram] ✅ Message sent successfully via POST")
                return true, postResult
            else
                print("[Telegram] ❌ POST also failed")
                return false, postResult
            end
        end
    else
        print("[Telegram] ❌ GET request failed:", response)
        return false, response
    end
end

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
    local ls = player:FindFirstChild("leaderstats")
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

-- ================= ADVANCED FISH RARITY DETECTION SYSTEM =================

-- Sistem deteksi rarity yang advanced
local function AdvancedRarityDetection(result)
    if not result or not result.Success then return "COMMON" end
    
    local rarity = "COMMON"
    
    pcall(function()
        -- Method 1: Cek dari Item properties langsung
        if result.Item then
            -- Cek jika ada property Rarity langsung
            if result.Item:FindFirstChild("Rarity") then
                local rarityValue = result.Item.Rarity.Value
                if rarityValue then
                    rarity = string.upper(tostring(rarityValue))
                    return rarity
                end
            end
            
            -- Cek dari Name untuk pattern khusus
            local itemName = string.upper(tostring(result.Item.Name))
            
            -- Deteksi berdasarkan kata kunci rarity di nama
            local rarityKeywords = {
                MYTHIC = {"MYTHIC", "ANCIENT", "DIVINE", "GODLY"},
                LEGENDARY = {"LEGENDARY", "DRAGON", "PHOENIX", "LEVIATHAN"},
                SECRET = {"SECRET", "HIDDEN", "MYSTERIOUS", "FORBIDDEN"},
                EPIC = {"EPIC", "CRYSTAL", "ROYAL", "MAJESTIC"},
                RARE = {"RARE", "SHARK", "WHALE", "OCTOPUS"},
                UNCOMMON = {"UNCOMMON", "SILVER", "MARBLE", "CORAL"}
            }
            
            for rarityType, keywords in pairs(rarityKeywords) do
                for _, keyword in ipairs(keywords) do
                    if string.find(itemName, keyword) then
                        rarity = rarityType
                        break
                    end
                end
                if rarity ~= "COMMON" then break end
            end
        end
        
        -- Method 2: Cek dari Sell Price (jika ada)
        if result.Item then
            local sellPrice = 0
            if result.Item:FindFirstChild("SellPrice") then
                sellPrice = result.Item.SellPrice.Value or 0
            end
            
            -- Estimasi rarity berdasarkan harga jual
            if sellPrice > 50000 then
                rarity = "MYTHIC"
            elseif sellPrice > 20000 then
                rarity = "LEGENDARY"
            elseif sellPrice > 10000 then
                rarity = "SECRET"
            elseif sellPrice > 5000 then
                rarity = "EPIC"
            elseif sellPrice > 2000 then
                rarity = "RARE"
            elseif sellPrice > 500 then
                rarity = "UNCOMMON"
            else
                rarity = "COMMON"
            end
        end
        
        -- Method 3: Cek visual properties (color, effects, dll)
        if result.Item then
            -- Cek jika item memiliki partikel effects (biasanya rare)
            for _, child in pairs(result.Item:GetDescendants()) do
                if child:IsA("ParticleEmitter") or child:IsA("Beam") or child:IsA("Trail") then
                    if rarity == "COMMON" then rarity = "RARE"
                    elseif rarity == "RARE" then rarity = "EPIC"
                    elseif rarity == "EPIC" then rarity = "LEGENDARY" end
                end
            end
        end
        
    end)
    
    return rarity
end

-- Fungsi untuk mendapatkan info ikan yang lebih akurat
local function GetAdvancedFishInfo(result)
    if not result or not result.Success then return nil end
    
    local fishInfo = {
        Name = "Unknown Fish",
        Tier = 1,
        SellPrice = 0,
        Rarity = "COMMON",
        Weight = 0,
        RealRarity = "COMMON"
    }
    
    pcall(function()
        -- Dapatkan info dasar dari result
        if result.Item then
            fishInfo.Name = result.Item.Name or "Unknown Fish"
            
            -- Coba dapatkan SellPrice
            if result.Item:FindFirstChild("SellPrice") then
                fishInfo.SellPrice = result.Item.SellPrice.Value or 0
            end
            
            -- Coba dapatkan Weight
            if result.Item:FindFirstChild("Weight") then
                fishInfo.Weight = result.Item.Weight.Value or 0
            elseif result.Item:FindFirstChild("Mass") then
                fishInfo.Weight = result.Item.Mass.Value or 0
            end
            
            -- Coba dapatkan Tier
            if result.Item:FindFirstChild("Tier") then
                fishInfo.Tier = result.Item.Tier.Value or 1
            end
        end
        
        -- Gunakan advanced rarity detection
        fishInfo.Rarity = AdvancedRarityDetection(result)
        fishInfo.RealRarity = fishInfo.Rarity
        
        -- Update fish count dari leaderstats
        local ls = player:FindFirstChild("leaderstats")
        if ls then
            local caught = ls:FindFirstChild("Caught") or ls:FindFirstChild("caught")
            if caught then
                fishCount = caught.Value
            end
        end
        
        -- Log untuk debugging
        print("[Fish Detection] 🎣 Caught: " .. fishInfo.Name .. " | Rarity: " .. fishInfo.Rarity .. " | Price: " .. fishInfo.SellPrice)
        
    end)
    
    return fishInfo
end

-- Fungsi BuildTelegramMessage yang diperbaiki (format lebih sederhana)
local function BuildTelegramMessage(fishInfo, fishId, fishRarity, weight)
    local playerName = player.Name or "Unknown"
    local displayName = player.DisplayName or playerName
    
    local fishName = fishInfo and fishInfo.Name or "Unknown Fish"
    local fishRarityStr = string.upper(tostring(fishInfo.Rarity or fishRarity or "UNKNOWN"))
    local weightDisplay = weight and string.format("%.2fkg", weight) or (fishInfo.Weight and string.format("%.2fkg", fishInfo.Weight)) or "?"
    local sellPrice = fishInfo and fishInfo.SellPrice and tostring(fishInfo.SellPrice) or "?"
    local tier = fishInfo and fishInfo.Tier and tostring(fishInfo.Tier) or "?"
    
    -- Format pesan yang lebih informatif
    local message = string.format(
        "🎣 *%s FISH CAUGHT!*\n\n" ..
        "*Player:* %s\n" ..
        "*Fish:* %s\n" .. 
        "*Rarity:* %s\n" ..
        "*Tier:* %s\n" ..
        "*Weight:* %s\n" ..
        "*Price:* %s coins\n" ..
        "*Time:* %s\n" ..
        "*Total Notified:* %d\n" ..
        "*Job ID:* %s\n\n" ..
        "⚡ *Auto-Fish System Active*",
        fishRarityStr,
        displayName,
        fishName,
        fishRarityStr,
        tier,
        weightDisplay,
        sellPrice,
        os.date("%H:%M:%S"),
        rareFishCount,
        game.JobId
    )
    
    return message
end

local function ShouldSendByRarity(rarity)
    if not TelegramConfig.Enabled then return false end
    if CountSelected() == 0 then return false end
    local key = string.upper(tostring(rarity or "UNKNOWN"))
    return TelegramConfig.SelectedRarities[key] == true
end

-- Fungsi untuk mengirim notifikasi ikan ke Telegram
local function SendFishNotification(fishInfo)
    if not TelegramConfig.Enabled then return end
    if not fishDetectionEnabled then return end
    if not ShouldSendByRarity(fishInfo.Rarity) then return end
    
    local message = BuildTelegramMessage(fishInfo, nil, fishInfo.Rarity, fishInfo.Weight)
    local success, result = SendTelegram(message)
    
    if success then
        rareFishCount += 1
        
        -- Update rare fish counter di GUI
        if RareFishLabel then
            RareFishLabel:Set("🌟 Rare Fish Notified: " .. rareFishCount)
        end
        
        print("[Telegram] ✅ Fish notification sent: " .. fishInfo.Name .. " (" .. fishInfo.Rarity .. ")")
        
        -- Show in-game notification
        Rayfield:Notify({
            Title = "🔔 " .. fishInfo.Rarity .. " FISH!",
            Content = fishInfo.Name .. " - Notification sent to Telegram",
            Duration = 5
        })
    else
        print("[Telegram] ❌ Failed to send fish notification: " .. tostring(result))
    end
end

-- Sistem monitor untuk fishing results yang lebih reliable
local fishingConnection = nil

local function SetupFishingMonitor()
    if fishingConnection then
        fishingConnection:Disconnect()
        fishingConnection = nil
    end
    
    fishingConnection = finishRemote.OnClientEvent:Connect(function(result)
        if not result or not result.Success then return end
        if not fishDetectionEnabled then return end
        
        -- Tunggu sebentar untuk memastikan data sudah terupdate
        task.wait(0.5)
        
        -- Dapatkan info ikan dengan advanced detection
        local fishInfo = GetAdvancedFishInfo(result)
        if not fishInfo then return end
        
        -- Simpan data ikan terakhir
        lastFishData = fishInfo
        
        -- Update fish count
        fishCount += 1
        if CounterLabel then
            CounterLabel:Set("🐟 Fish Caught: " .. fishCount)
        end
        
        -- Kirim notifikasi ke Telegram jika sesuai filter
        SendFishNotification(fishInfo)
        
        -- Show in-game notification untuk semua ikan yang sesuai filter
        if ShouldSendByRarity(fishInfo.Rarity) then
            Rayfield:Notify({
                Title = "🎣 " .. fishInfo.Rarity .. " FISH!",
                Content = "Caught: " .. fishInfo.Name .. "\nPrice: " .. fishInfo.SellPrice .. " coins",
                Duration = 4
            })
        end
    end)
end

-- Fungsi test connection yang diperbaiki
local function TestTelegramConnection()
    if not TelegramConfig.ChatID or TelegramConfig.ChatID == "" then
        Rayfield:Notify({
            Title = "❌ Chat ID Required",
            Content = "Please enter your Chat ID first",
            Duration = 4
        })
        return false
    end

    local testMessage = "🤖 *TEST NOTIFICATION* \n\n" ..
                       "✅ *Auto Fish Bot Connection Test*\n" ..
                       "👤 Player: " .. player.Name .. "\n" ..
                       "🕒 Time: " .. os.date("%H:%M:%S") .. "\n" ..
                       "🔗 Job ID: " .. game.JobId .. "\n\n" ..
                       "🌟 *Status: CONNECTED SUCCESSFULLY*"

    local success, result = SendTelegram(testMessage)
    
    if success then
        Rayfield:Notify({
            Title = "✅ Telegram Connected",
            Content = "Test message sent successfully!",
            Duration = 5
        })
        return true
    else
        Rayfield:Notify({
            Title = "❌ Connection Failed", 
            Content = "Check token & chat ID",
            Duration = 6
        })
        return false
    end
end

-- ================= TELEPORT SYSTEM (FROM NIKZZ) =================

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
    local character = player.Character
    if character and character:FindFirstChild("HumanoidRootPart") then
        character.HumanoidRootPart.CFrame = CFrame.new(pos)
        return true
    end
    return false
end

local function ScanActiveEvents()
    local events = {}
    local validEvents = {
        "megalodon", "whale", "kraken", "hunt", "Ghost Worm", "Mount Hallow",
        "admin", "Hallow Bay", "worm", "blackhole", "HalloweenFastTravel"
    }

    for _, obj in pairs(Workspace:GetDescendants()) do
        if obj:IsA("Model") or obj:IsA("Folder") then
            local name = obj.Name:lower()

            for _, keyword in ipairs(validEvents) do
                if name:find(keyword) and not name:find("boat") and not name:find("sharki") then
                    local exists = false
                    for _, e in ipairs(events) do
                        if e.Name == obj.Name then
                            exists = true
                            break
                        end
                    end

                    if not exists then
                        local pos = Vector3.new(0, 0, 0)

                        if obj:IsA("Model") then
                            pcall(function()
                                pos = obj:GetModelCFrame().Position
                            end)
                        elseif obj:IsA("BasePart") then
                            pos = obj.Position
                        elseif obj:IsA("Folder") and #obj:GetChildren() > 0 then
                            local child = obj:GetChildren()[1]
                            if child:IsA("Model") then
                                pcall(function()
                                    pos = child:GetModelCFrame().Position
                                end)
                            elseif child:IsA("BasePart") then
                                pos = child.Position
                            end
                        end

                        table.insert(events, {
                            Name = obj.Name,
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

-- ================= UTILITY SYSTEM (FROM NIKZZ) =================

local UtilityConfig = {
    WalkSpeed = 16,
    JumpPower = 50,
    WalkOnWater = false,
    NoClip = false,
    XRay = false,
    ESPEnabled = false,
    ESPDistance = 20,
    Brightness = 2,
    TimeOfDay = 14,
    InfiniteZoom = false
}

local WalkOnWaterConnection = nil
local NoClipConnection = nil
local XRayConnection = nil
local ESPConnection = nil
local InfiniteZoomConnection = nil
local LightingConnection = nil

-- Walk on Water Function
local function WalkOnWater()
    if WalkOnWaterConnection then
        WalkOnWaterConnection:Disconnect()
        WalkOnWaterConnection = nil
    end
    
    if not UtilityConfig.WalkOnWater then return end
    
    task.spawn(function()
        print("[WALK ON WATER] Activated")
        
        WalkOnWaterConnection = RunService.Heartbeat:Connect(function()
            if not UtilityConfig.WalkOnWater then
                if WalkOnWaterConnection then
                    WalkOnWaterConnection:Disconnect()
                    WalkOnWaterConnection = nil
                end
                return
            end
            
            pcall(function()
                local character = player.Character
                if character and character:FindFirstChild("HumanoidRootPart") and character:FindFirstChild("Humanoid") then
                    local hrp = character.HumanoidRootPart
                    local humanoid = character.Humanoid
                    
                    local rayOrigin = hrp.Position
                    local rayDirection = Vector3.new(0, -20, 0)
                    
                    local raycastParams = RaycastParams.new()
                    raycastParams.FilterDescendantsInstances = {character}
                    raycastParams.FilterType = Enum.RaycastFilterType.Blacklist
                    
                    local raycastResult = Workspace:Raycast(rayOrigin, rayDirection, raycastParams)
                    
                    if raycastResult and raycastResult.Instance then
                        local hitPart = raycastResult.Instance
                        
                        if hitPart.Name:lower():find("water") or hitPart.Material == Enum.Material.Water then
                            local waterSurfaceY = raycastResult.Position.Y
                            local playerY = hrp.Position.Y
                            
                            if playerY < waterSurfaceY + 3 then
                                local newPosition = Vector3.new(
                                    hrp.Position.X,
                                    waterSurfaceY + 3.5,
                                    hrp.Position.Z
                                )
                                hrp.CFrame = CFrame.new(newPosition)
                            end
                        end
                    end
                end
            end)
        end)
    end)
end

-- NoClip Function
local function NoClip()
    if NoClipConnection then
        NoClipConnection:Disconnect()
        NoClipConnection = nil
    end
    
    if not UtilityConfig.NoClip then return end
    
    task.spawn(function()
        NoClipConnection = RunService.Stepped:Connect(function()
            if not UtilityConfig.NoClip then
                if NoClipConnection then
                    NoClipConnection:Disconnect()
                    NoClipConnection = nil
                end
                return
            end
            
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
        end)
    end)
end

-- XRay Function
local function XRay()
    if XRayConnection then
        XRayConnection:Disconnect()
        XRayConnection = nil
    end
    
    if not UtilityConfig.XRay then return end
    
    task.spawn(function()
        -- Apply initial transparency
        pcall(function()
            for _, part in pairs(Workspace:GetDescendants()) do
                if part:IsA("BasePart") and part.Transparency < 0.5 then
                    part.LocalTransparencyModifier = 0.5
                end
            end
        end)
        
        XRayConnection = Workspace.DescendantAdded:Connect(function(part)
            if UtilityConfig.XRay and part:IsA("BasePart") and part.Transparency < 0.5 then
                part.LocalTransparencyModifier = 0.5
            end
        end)
    end)
end

-- ESP Function
local function ESP()
    if ESPConnection then
        ESPConnection:Disconnect()
        ESPConnection = nil
    end
    
    if not UtilityConfig.ESPEnabled then return end
    
    task.spawn(function()
        local highlights = {}
        
        local function createHighlight(targetPlayer)
            if targetPlayer == player then return end
            if not targetPlayer.Character then return end
            
            local highlight = Instance.new("Highlight")
            highlight.Parent = targetPlayer.Character
            highlight.FillColor = Color3.fromRGB(255, 0, 0)
            highlight.OutlineColor = Color3.fromRGB(255, 255, 255)
            highlight.FillTransparency = 0.5
            highlight.OutlineTransparency = 0
            highlight.DepthMode = Enum.HighlightDepthMode.AlwaysOnTop
            
            highlights[targetPlayer] = highlight
        end
        
        local function removeHighlight(targetPlayer)
            if highlights[targetPlayer] then
                highlights[targetPlayer]:Destroy()
                highlights[targetPlayer] = nil
            end
        end
        
        -- Create highlights for existing players
        for _, targetPlayer in pairs(Players:GetPlayers()) do
            createHighlight(targetPlayer)
        end
        
        -- Handle new players
        Players.PlayerAdded:Connect(function(targetPlayer)
            if UtilityConfig.ESPEnabled then
                targetPlayer.CharacterAdded:Connect(function()
                    createHighlight(targetPlayer)
                end)
            end
        end)
        
        -- Handle player leaving
        Players.PlayerRemoving:Connect(function(targetPlayer)
            removeHighlight(targetPlayer)
        end)
        
        -- Handle character changes
        for _, targetPlayer in pairs(Players:GetPlayers()) do
            targetPlayer.CharacterAdded:Connect(function()
                if UtilityConfig.ESPEnabled then
                    createHighlight(targetPlayer)
                end
            end)
        end
        
        ESPConnection = RunService.Heartbeat:Connect(function()
            if not UtilityConfig.ESPEnabled then
                for targetPlayer, highlight in pairs(highlights) do
                    highlight:Destroy()
                end
                highlights = {}
                if ESPConnection then
                    ESPConnection:Disconnect()
                    ESPConnection = nil
                end
                return
            end
            
            -- Update highlights based on distance
            local character = player.Character
            if character and character:FindFirstChild("HumanoidRootPart") then
                local playerPos = character.HumanoidRootPart.Position
                
                for targetPlayer, highlight in pairs(highlights) do
                    if targetPlayer.Character and targetPlayer.Character:FindFirstChild("HumanoidRootPart") then
                        local targetPos = targetPlayer.Character.HumanoidRootPart.Position
                        local distance = (playerPos - targetPos).Magnitude
                        
                        if distance <= UtilityConfig.ESPDistance then
                            highlight.Enabled = true
                            -- Change color based on distance
                            if distance < 10 then
                                highlight.FillColor = Color3.fromRGB(255, 0, 0) -- Red for close
                            elseif distance < 20 then
                                highlight.FillColor = Color3.fromRGB(255, 165, 0) -- Orange for medium
                            else
                                highlight.FillColor = Color3.fromRGB(0, 255, 0) -- Green for far
                            end
                        else
                            highlight.Enabled = false
                        end
                    else
                        highlight.Enabled = false
                    end
                end
            end
        end)
    end)
end

-- Infinite Zoom Function
local function InfiniteZoom()
    if InfiniteZoomConnection then
        InfiniteZoomConnection:Disconnect()
        InfiniteZoomConnection = nil
    end
    
    if not UtilityConfig.InfiniteZoom then return end
    
    task.spawn(function()
        InfiniteZoomConnection = RunService.Heartbeat:Connect(function()
            if not UtilityConfig.InfiniteZoom then
                if InfiniteZoomConnection then
                    InfiniteZoomConnection:Disconnect()
                    InfiniteZoomConnection = nil
                end
                return
            end
            
            pcall(function()
                if player:FindFirstChild("CameraMaxZoomDistance") then
                    player.CameraMaxZoomDistance = math.huge
                end
            end)
        end)
    end)
end

-- Lighting Control Function
local function ApplyPermanentLighting()
    if LightingConnection then 
        LightingConnection:Disconnect() 
    end
    
    LightingConnection = RunService.Heartbeat:Connect(function()
        Lighting.Brightness = UtilityConfig.Brightness
        Lighting.ClockTime = UtilityConfig.TimeOfDay
    end)
end

-- Remove Fog Function
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

-- GUI Setup
local Window = Rayfield:CreateWindow({
    Name = "🎣 Auto Fishing Hub",
    LoadingTitle = "Fishing AutoFarm",
    LoadingSubtitle = "By HyRexxyy x GPT + Nikzz Features",
    ConfigurationSaving = { Enabled = true, FolderName = "AutoFishSettings" },
    KeySystem = false
})

local MainTab = Window:CreateTab("⚙️ Main Controls")
local CounterLabel = MainTab:CreateLabel("🐟 Fish Caught: 0")

-- ================= TELEPORT TAB =================
local TeleportTab = Window:CreateTab("📍 Teleport", 4483362458)

TeleportTab:CreateSection("Islands Teleport")

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
            if TeleportToPosition(IslandsData[index].Position) then
                Rayfield:Notify({
                    Title = "📍 Teleported",
                    Content = "Teleported to " .. IslandsData[index].Name,
                    Duration = 3
                })
            else
                Rayfield:Notify({
                    Title = "❌ Teleport Failed",
                    Content = "Character not found",
                    Duration = 3
                })
            end
        end
    end
})

TeleportTab:CreateSection("Events Teleport")

local EventDrop = TeleportTab:CreateDropdown({
    Name = "Select Event",
    Options = {"Load events first"},
    CurrentOption = {"Load events first"},
    Callback = function(Option) end
})

TeleportTab:CreateButton({
    Name = "Load Events",
    Callback = function()
        local events = ScanActiveEvents()
        local options = {}
        
        for i, event in ipairs(events) do
            table.insert(options, string.format("%d. %s", i, event.Name))
        end
        
        if #options == 0 then
            options = {"No events active"}
        end
        
        EventDrop:Refresh(options)
        Rayfield:Notify({
            Title = "Events Loaded",
            Content = string.format("Found %d events", #events),
            Duration = 3
        })
    end
})

TeleportTab:CreateButton({
    Name = "Teleport to Event",
    Callback = function()
        local selected = EventDrop.CurrentOption[1]
        local index = tonumber(selected:match("^(%d+)%."))
        
        if index then
            local events = ScanActiveEvents()
            if events[index] then
                if TeleportToPosition(events[index].Position) then
                    Rayfield:Notify({
                        Title = "📍 Teleported",
                        Content = "Teleported to event: " .. events[index].Name,
                        Duration = 3
                    })
                else
                    Rayfield:Notify({
                        Title = "❌ Teleport Failed",
                        Content = "Character not found",
                        Duration = 3
                    })
                end
            end
        end
    end
})

TeleportTab:CreateSection("Players Teleport")

local PlayersList = {}
local PlayerDrop = TeleportTab:CreateDropdown({
    Name = "Select Player",
    Options = {"Load players first"},
    CurrentOption = {"Load players first"},
    Callback = function(Option) end
})

TeleportTab:CreateButton({
    Name = "Load Players",
    Callback = function()
        PlayersList = {}
        for _, targetPlayer in pairs(Players:GetPlayers()) do
            if targetPlayer ~= player and targetPlayer.Character then
                table.insert(PlayersList, targetPlayer.Name)
            end
        end
        
        if #PlayersList == 0 then
            PlayersList = {"No players online"}
        end
        
        PlayerDrop:Refresh(PlayersList)
        Rayfield:Notify({
            Title = "Players Loaded",
            Content = string.format("Found %d players", #PlayersList),
            Duration = 3
        })
    end
})

TeleportTab:CreateButton({
    Name = "Teleport to Player",
    Callback = function()
        local selected = PlayerDrop.CurrentOption[1]
        local targetPlayer = Players:FindFirstChild(selected)
        
        if targetPlayer and targetPlayer.Character then
            local hrp = targetPlayer.Character:FindFirstChild("HumanoidRootPart")
            local character = player.Character
            if hrp and character and character:FindFirstChild("HumanoidRootPart") then
                character.HumanoidRootPart.CFrame = hrp.CFrame * CFrame.new(0, 3, 0)
                Rayfield:Notify({
                    Title = "📍 Teleported", 
                    Content = "Teleported to " .. selected,
                    Duration = 3
                })
            else
                Rayfield:Notify({
                    Title = "❌ Teleport Failed",
                    Content = "Character not found",
                    Duration = 3
                })
            end
        end
    end
})

-- ================= HOOK SYSTEM TAB FIXED =================
local HookTab = Window:CreateTab("🔔 Hook System", 4483362458)

HookTab:CreateSection("Telegram Hook Settings")

HookTab:CreateToggle({ 
    Name = "Enable Telegram Hook", 
    CurrentValue = TelegramConfig.Enabled, 
    Callback = function(v) 
        TelegramConfig.Enabled = v 
        Rayfield:Notify({
            Title = "🔔 Telegram Hook",
            Content = v and "Enabled" or "Disabled",
            Duration = 3
        })
    end 
})

HookTab:CreateInput({
    Name = "Telegram Chat ID",
    PlaceholderText = "Enter Chat ID (example: 6420726459)",
    RemoveTextAfterFocusLost = false,
    Callback = function(Text)
        TelegramConfig.ChatID = Text
        Rayfield:Notify({
            Title = "💾 Chat ID Saved",
            Content = "Chat ID updated: " .. Text,
            Duration = 3
        })
    end,
})

HookTab:CreateParagraph({ 
    Title = "📋 Configuration Info", 
    Content = "Bot Token: " .. TELEGRAM_BOT_TOKEN .. "\nChat ID: " .. (TelegramConfig.ChatID or "Not set") 
})

HookTab:CreateSection("Connection Test")

HookTab:CreateButton({ 
    Name = "🔗 Test Telegram Connection", 
    Callback = function()
        TestTelegramConnection()
    end 
})

HookTab:CreateSection("Rarity Filter (Max 3)")

local rarities = {"MYTHIC", "LEGENDARY", "SECRET", "EPIC", "RARE", "UNCOMMON", "COMMON"}
for _, r in ipairs(rarities) do 
    TelegramConfig.SelectedRarities[r] = TelegramConfig.SelectedRarities[r] or false 
end

for _, r in ipairs(rarities) do
    HookTab:CreateToggle({ 
        Name = r, 
        CurrentValue = TelegramConfig.SelectedRarities[r], 
        Callback = function(val)
            if val then
                local selectedCount = 0
                for _, v in pairs(TelegramConfig.SelectedRarities) do
                    if v then selectedCount = selectedCount + 1 end
                end
                
                if selectedCount >= TelegramConfig.MaxSelection then
                    Rayfield:Notify({
                        Title = "⚠️ Maximum Reached",
                        Content = "You can only select " .. TelegramConfig.MaxSelection .. " rarities",
                        Duration = 3
                    })
                    return
                else
                    TelegramConfig.SelectedRarities[r] = true
                    Rayfield:Notify({
                        Title = "✅ Rarity Added",
                        Content = r .. " notifications enabled",
                        Duration = 2
                    })
                end
            else
                TelegramConfig.SelectedRarities[r] = false
                Rayfield:Notify({
                    Title = "❌ Rarity Removed", 
                    Content = r .. " notifications disabled",
                    Duration = 2
                })
            end
        end 
    })
end

HookTab:CreateSection("Fish Detection Settings")

local RareFishLabel = HookTab:CreateLabel("🌟 Rare Fish Notified: 0")

HookTab:CreateToggle({
    Name = "🔔 Enable Fish Detection",
    CurrentValue = true,
    Callback = function(val)
        fishDetectionEnabled = val
        if val then
            SetupFishingMonitor()
            Rayfield:Notify({
                Title = "✅ Fish Detection Enabled",
                Content = "Telegram notifications active for selected rarities",
                Duration = 4
            })
        else
            Rayfield:Notify({
                Title = "❌ Fish Detection Disabled", 
                Content = "Telegram notifications paused",
                Duration = 3
            })
        end
    end
})

HookTab:CreateButton({
    Name = "🔄 Reset Fish Counter",
    Callback = function()
        rareFishCount = 0
        if RareFishLabel then
            RareFishLabel:Set("🌟 Rare Fish Notified: 0")
        end
        Rayfield:Notify({
            Title = "✅ Counter Reset",
            Content = "Rare fish counter has been reset",
            Duration = 3
        })
    end
})

HookTab:CreateSection("Test Notifications")

HookTab:CreateButton({ 
    Name = "🎣 Test LEGENDARY Fish", 
    Callback = function()
        if not TelegramConfig.ChatID or TelegramConfig.ChatID == "" then
            Rayfield:Notify({
                Title = "❌ Chat ID Required",
                Content = "Please enter your Chat ID first",
                Duration = 4
            })
            return
        end

        local testFish = {
            Name = "⚡ Thunder Dragon Fish",
            Tier = 5,
            SellPrice = 25000,
            Rarity = "LEGENDARY",
            Weight = 3.45,
            RealRarity = "LEGENDARY"
        }
        
        SendFishNotification(testFish)
    end 
})

HookTab:CreateButton({ 
    Name = "💎 Test EPIC Fish", 
    Callback = function()
        if not TelegramConfig.ChatID or TelegramConfig.ChatID == "" then
            Rayfield:Notify({
                Title = "❌ Chat ID Required",
                Content = "Please enter your Chat ID first",
                Duration = 4
            })
            return
        end

        local testFish = {
            Name = "Crystal Shark",
            Tier = 4, 
            SellPrice = 12000,
            Rarity = "EPIC",
            Weight = 2.15,
            RealRarity = "EPIC"
        }
        
        SendFishNotification(testFish)
    end 
})

HookTab:CreateButton({ 
    Name = "🎣 Test COMMON Fish", 
    Callback = function()
        if not TelegramConfig.ChatID or TelegramConfig.ChatID == "" then
            Rayfield:Notify({
                Title = "❌ Chat ID Required",
                Content = "Please enter your Chat ID first",
                Duration = 4
            })
            return
        end

        local testFish = {
            Name = "Common Goldfish",
            Tier = 1,
            SellPrice = 100,
            Rarity = "COMMON",
            Weight = 0.5,
            RealRarity = "COMMON"
        }
        
        SendFishNotification(testFish)
    end 
})

HookTab:CreateButton({ 
    Name = "🎣 Test UNCOMMON Fish", 
    Callback = function()
        if not TelegramConfig.ChatID or TelegramConfig.ChatID == "" then
            Rayfield:Notify({
                Title = "❌ Chat ID Required",
                Content = "Please enter your Chat ID first",
                Duration = 4
            })
            return
        end

        local testFish = {
            Name = "Uncommon Rainbow Trout",
            Tier = 2,
            SellPrice = 750,
            Rarity = "UNCOMMON",
            Weight = 1.8,
            RealRarity = "UNCOMMON"
        }
        
        SendFishNotification(testFish)
    end 
})

HookTab:CreateButton({ 
    Name = "📊 Send Status Report", 
    Callback = function()
        if not TelegramConfig.ChatID or TelegramConfig.ChatID == "" then
            Rayfield:Notify({
                Title = "❌ Chat ID Required",
                Content = "Please enter your Chat ID first",
                Duration = 4
            })
            return
        end

        local statusMessage = string.format(
            "📊 *FISHING STATUS REPORT*\n\n" ..
            "👤 Player: %s\n" ..
            "🎣 Total Fish: %d\n" ..
            "🌟 Rare Fish Notified: %d\n" ..
            "🕒 Session Time: %s\n" ..
            "🔗 Job ID: %s\n\n" ..
            "⚡ *Status: ACTIVE*",
            player.Name,
            fishCount or 0,
            rareFishCount or 0,
            os.date("%H:%M:%S"),
            game.JobId
        )
        
        local success, result = SendTelegram(statusMessage)

        Rayfield:Notify({
            Title = success and "✅ Report Sent" or "❌ Send Failed",
            Content = success and "Status report delivered!" or "Failed to send report",
            Duration = 4
        })
    end 
})

HookTab:CreateSection("Debug Tools")

HookTab:CreateButton({
    Name = "🔧 Debug Last Fish",
    Callback = function()
        if lastFishData then
            local debugInfo = string.format(
                "Name: %s\nRarity: %s\nPrice: %d\nWeight: %.2f\nTier: %d",
                lastFishData.Name,
                lastFishData.Rarity,
                lastFishData.SellPrice,
                lastFishData.Weight,
                lastFishData.Tier
            )
            
            Rayfield:Notify({
                Title = "🔍 Last Fish Debug",
                Content = debugInfo,
                Duration = 8
            })
            
            print("[Debug] Last Fish:", lastFishData)
        else
            Rayfield:Notify({
                Title = "❌ No Fish Data",
                Content = "No fish has been caught yet",
                Duration = 3
            })
        end
    end
})

-- ================= UTILITY TAB =================
local UtilityTab = Window:CreateTab("⚡ Utility", 4483362458)

UtilityTab:CreateSection("Movement Settings")

UtilityTab:CreateSlider({
    Name = "Walk Speed",
    Range = {16, 500},
    Increment = 1,
    CurrentValue = UtilityConfig.WalkSpeed,
    Callback = function(Value)
        UtilityConfig.WalkSpeed = Value
        local character = player.Character
        if character and character:FindFirstChild("Humanoid") then
            character.Humanoid.WalkSpeed = Value
        end
    end
})

UtilityTab:CreateSlider({
    Name = "Jump Power",
    Range = {50, 500},
    Increment = 5,
    CurrentValue = UtilityConfig.JumpPower,
    Callback = function(Value)
        UtilityConfig.JumpPower = Value
        local character = player.Character
        if character and character:FindFirstChild("Humanoid") then
            character.Humanoid.JumpPower = Value
        end
    end
})

UtilityTab:CreateButton({
    Name = "Reset Movement",
    Callback = function()
        UtilityConfig.WalkSpeed = 16
        UtilityConfig.JumpPower = 50
        local character = player.Character
        if character and character:FindFirstChild("Humanoid") then
            character.Humanoid.WalkSpeed = 16
            character.Humanoid.JumpPower = 50
        end
        Rayfield:Notify({
            Title = "✅ Movement Reset",
            Content = "Walk speed and jump power reset to default",
            Duration = 3
        })
    end
})

UtilityTab:CreateSection("Special Abilities")

UtilityTab:CreateToggle({
    Name = "Walk on Water",
    CurrentValue = UtilityConfig.WalkOnWater,
    Callback = function(Value)
        UtilityConfig.WalkOnWater = Value
        if Value then
            WalkOnWater()
            Rayfield:Notify({
                Title = "🌊 Walk on Water",
                Content = "Enabled - You can now walk on water!",
                Duration = 3
            })
        else
            Rayfield:Notify({
                Title = "🌊 Walk on Water", 
                Content = "Disabled",
                Duration = 2
            })
        end
    end
})

UtilityTab:CreateToggle({
    Name = "NoClip",
    CurrentValue = UtilityConfig.NoClip,
    Callback = function(Value)
        UtilityConfig.NoClip = Value
        if Value then
            NoClip()
            Rayfield:Notify({
                Title = "👻 NoClip",
                Content = "Enabled - You can pass through walls!",
                Duration = 3
            })
        else
            Rayfield:Notify({
                Title = "👻 NoClip",
                Content = "Disabled",
                Duration = 2
            })
        end
    end
})

UtilityTab:CreateToggle({
    Name = "XRay Vision",
    CurrentValue = UtilityConfig.XRay,
    Callback = function(Value)
        UtilityConfig.XRay = Value
        if Value then
            XRay()
            Rayfield:Notify({
                Title = "🔍 XRay Vision",
                Content = "Enabled - See through walls!",
                Duration = 3
            })
        else
            -- Reset transparency
            pcall(function()
                for _, part in pairs(Workspace:GetDescendants()) do
                    if part:IsA("BasePart") then
                        part.LocalTransparencyModifier = 0
                    end
                end
            end)
            Rayfield:Notify({
                Title = "🔍 XRay Vision",
                Content = "Disabled",
                Duration = 2
            })
        end
    end
})

UtilityTab:CreateSection("Player ESP")

UtilityTab:CreateToggle({
    Name = "Enable ESP",
    CurrentValue = UtilityConfig.ESPEnabled,
    Callback = function(Value)
        UtilityConfig.ESPEnabled = Value
        if Value then
            ESP()
            Rayfield:Notify({
                Title = "🎯 Player ESP",
                Content = "Enabled - See other players through walls!",
                Duration = 3
            })
        else
            Rayfield:Notify({
                Title = "🎯 Player ESP",
                Content = "Disabled",
                Duration = 2
            })
        end
    end
})

UtilityTab:CreateSlider({
    Name = "ESP Distance",
    Range = {10, 100},
    Increment = 5,
    CurrentValue = UtilityConfig.ESPDistance,
    Callback = function(Value)
        UtilityConfig.ESPDistance = Value
    end
})

UtilityTab:CreateSection("Graphics & Lighting")

UtilityTab:CreateSlider({
    Name = "Brightness",
    Range = {0, 10},
    Increment = 0.5,
    CurrentValue = UtilityConfig.Brightness,
    Callback = function(Value)
        UtilityConfig.Brightness = Value
        Lighting.Brightness = Value
        ApplyPermanentLighting()
    end
})

UtilityTab:CreateSlider({
    Name = "Time of Day",
    Range = {0, 24},
    Increment = 0.5,
    CurrentValue = UtilityConfig.TimeOfDay,
    Callback = function(Value)
        UtilityConfig.TimeOfDay = Value
        Lighting.ClockTime = Value
        ApplyPermanentLighting()
    end
})

UtilityTab:CreateButton({
    Name = "Remove Fog",
    Callback = function()
        RemoveFog()
        Rayfield:Notify({
            Title = "☀️ Fog Removed",
            Content = "Fog has been permanently disabled",
            Duration = 3
        })
    end
})

UtilityTab:CreateToggle({
    Name = "Infinite Zoom",
    CurrentValue = UtilityConfig.InfiniteZoom,
    Callback = function(Value)
        UtilityConfig.InfiniteZoom = Value
        if Value then
            InfiniteZoom()
            Rayfield:Notify({
                Title = "🔍 Infinite Zoom",
                Content = "Enabled - No zoom limits!",
                Duration = 3
            })
        else
            Rayfield:Notify({
                Title = "🔍 Infinite Zoom",
                Content = "Disabled",
                Duration = 2
            })
        end
    end
})

UtilityTab:CreateSection("Extra Features")

UtilityTab:CreateButton({
    Name = "Infinite Jump",
    Callback = function()
        UserInputService.JumpRequest:Connect(function()
            local character = player.Character
            if character and character:FindFirstChild("Humanoid") then
                character.Humanoid:ChangeState(Enum.HumanoidStateType.Jumping)
            end
        end)
        Rayfield:Notify({
            Title = "🦘 Infinite Jump",
            Content = "Enabled - Jump infinitely in the air!",
            Duration = 3
        })
    end
})

-- ================= ORIGINAL MAIN CONTROLS =================

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

-- ANTI AFK TOGGLE
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

-- ================= INITIALIZATION =================

-- Setup systems saat script mulai
task.spawn(function()
    task.wait(3) -- Tunggu GUI load dulu
    SetupFishingMonitor()
    ApplyPermanentLighting()
    
    print("[Fish Detection] ✅ Advanced fishing monitor activated")
    print("[Rarity Monitor] ✅ Real-time rarity detection ready")
    print("[Telegram] ✅ Hook system initialized")
    print("[Telegram] ✅ Token:", TELEGRAM_BOT_TOKEN)
    print("[Telegram] ✅ Chat ID:", TelegramConfig.ChatID or "Not set")
    print("[Telegram] ✅ Enabled:", TelegramConfig.Enabled)
    
    Rayfield:Notify({
        Title = "🔔 Advanced Fish Detection",
        Content = "Rarity detection system activated!\nTelegram notifications ready for selected rarities.",
        Duration = 6
    })
end)

-- Notifikasi awal
Rayfield:Notify({
    Title = "✅ AutoFish GUI Loaded",
    Content = "Event-based detection ready! + Nikzz Features (Teleport, Hook System, Utility) Added!",
    Duration = 6
})

print("🎣 Auto Fishing Hub + Nikzz Features Loaded Successfully!")
print("📍 Teleport System: 21 Islands + Events + Players")
print("🔔 Hook System: Telegram Notifications with Advanced Rarity Detection")  
print("⚡ Utility: Walk on Water, NoClip, XRay, ESP, and more!")
