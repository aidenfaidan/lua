--// AUTO FISH GUI - Versi HyRexxyy Event-Based + Nikzz Features
local Rayfield = loadstring(game:HttpGet('https://sirius.menu/rayfield'))()
local ReplicatedStorage = game:GetService("ReplicatedStorage")
local Players = game:GetService("Players")
local player = Players.LocalPlayer
local VirtualUser = game:GetService("VirtualUser")

-- Variabel utama
local antiAFK = false

-- GUI Setup
local Window = Rayfield:CreateWindow({
    Name = "🎣 Auto Fishing Hub",
    LoadingTitle = "Fishing AutoFarm",
    LoadingSubtitle = "By HyRexxyy x GPT + Nikzz Features",
    ConfigurationSaving = { Enabled = true, FolderName = "AutoFishSettings" },
    KeySystem = false
})

local MainTab = Window:CreateTab("⚙️ Main Controls")

-- ================= ANTI AFK SYSTEM =================
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
    Content = "Anti AFK Feature Ready!",
    Duration = 6
})

print("🎣 Auto Fishing Hub - Anti AFK Feature Loaded Successfully!")
