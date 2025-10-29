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
            -- Fallback menggunakan game:HttpGet untuk GET requests
            if method == "GET" then
                return {Success = true, Body = game:HttpGet(url)}
            else
                return {Success = false, Body = "No HTTP client available"}
            end
        end
    end)
    return success, result
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
    local url = string.format("https://api.telegram.org/bot%s/sendMessage?chat_id=%s&text=%s&parse_mode=Markdown", 
        cleanToken, cleanChatID, game:HttpGetAsync("https://api.telegram.org/encode", message))
    
    local success, response = pcall(function()
        return game:HttpGet(url)
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
            
            local jsonPayload = game:GetService("HttpService"):JSONEncode(payload)
            
            local postSuccess, postResult = sendHTTPRequest(postUrl, "POST", jsonPayload, {
                ["Content-Type"] = "application/json"
            })
            
            if postSuccess and postResult and (postResult.Success or postResult.StatusCode == 200) then
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

-- Fungsi BuildTelegramMessage yang diperbaiki (format lebih sederhana)
local function BuildTelegramMessage(fishInfo, fishId, fishRarity, weight)
    local playerName = player.Name or "Unknown"
    local displayName = player.DisplayName or playerName
    
    local fishName = fishInfo and fishInfo.Name or "Unknown Fish"
    local fishRarityStr = string.upper(tostring(fishRarity or "UNKNOWN"))
    local weightDisplay = weight and string.format("%.2fkg", weight) or "?"
    local sellPrice = fishInfo and fishInfo.SellPrice and tostring(fishInfo.SellPrice) or "?"
    
    -- Format pesan yang lebih sederhana dan pasti work
    local message = string.format(
        "🎣 *FISH CAUGHT!*\n\n" ..
        "*Player:* %s\n" ..
        "*Fish:* %s\n" .. 
        "*Rarity:* %s\n" ..
        "*Weight:* %s\n" ..
        "*Price:* %s coins\n" ..
        "*Time:* %s\n" ..
        "*Job ID:* %s",
        displayName,
        fishName,
        fishRarityStr,
        weightDisplay,
        sellPrice,
        os.date("%H:%M:%S"),
        game.JobId
    )
    
    return message
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
            Content = "Check token & chat ID\nError: " .. tostring(result),
            Duration = 6
        })
        return false
    end
end

-- Fungsi untuk handle fish catch notification
local function NotifyFishCaught(fishInfo, rarity, weight)
    if not TelegramConfig.Enabled then return end
    if not ShouldSendByRarity(rarity) then return end
    
    local message = BuildTelegramMessage(fishInfo, nil, rarity, weight)
    local success, result = SendTelegram(message)
    
    if success then
        print("[Telegram] ✅ Fish notification sent")
    else
        print("[Telegram] ❌ Failed to send fish notification:", result)
    end
end

-- ================= HOOK SYSTEM TAB (DIPERBAIKI) =================
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
            Weight = 3.45
        }
        
        local success = SendTelegram(BuildTelegramMessage(testFish, nil, "LEGENDARY", 3.45))

        Rayfield:Notify({
            Title = success and "✅ Test Sent" or "❌ Test Failed",
            Content = success and "Legendary fish test sent!" or "Failed to send test",
            Duration = 4
        })
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
            Weight = 2.15
        }
        
        local success = SendTelegram(BuildTelegramMessage(testFish, nil, "EPIC", 2.15))

        Rayfield:Notify({
            Title = success and "✅ Test Sent" or "❌ Test Failed",
            Content = success and "Epic fish test sent!" or "Failed to send test",
            Duration = 4
        })
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
            "🌟 Rare Fish: %d\n" ..
            "🕒 Session Time: %s\n" ..
            "🔗 Job ID: %s\n\n" ..
            "⚡ *Status: ACTIVE*",
            player.Name,
            fishCount or 0,
            rareFishCount or 0, 
            os.date("%H:%M:%S"),
            game.JobId
        )
        
        local success = SendTelegram(statusMessage)

        Rayfield:Notify({
            Title = success and "✅ Report Sent" or "❌ Send Failed",
            Content = success and "Status report delivered!" or "Failed to send report",
            Duration = 4
        })
    end 
})

-- Tambahkan ini di bagian akhir script untuk test otomatis
task.spawn(function()
    task.wait(5)
    print("[Telegram] System initialized")
    print("[Telegram] Bot Token:", TELEGRAM_BOT_TOKEN)
    print("[Telegram] Chat ID:", TelegramConfig.ChatID or "Not set")
    print("[Telegram] Enabled:", TelegramConfig.Enabled)
end)
