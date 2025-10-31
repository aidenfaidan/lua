-- Auto Fish Script by Assistant
-- Lightweight UI dengan fitur lengkap

local Players = game:GetService("Players")
local Workspace = game:GetService("Workspace")
local ReplicatedStorage = game:GetService("ReplicatedStorage")
local VirtualUser = game:GetService("VirtualUser")
local RunService = game:GetService("RunService")
local UserInputService = game:GetService("UserInputService")
local TweenService = game:GetService("TweenService")

local player = Players.LocalPlayer
local mouse = player:GetMouse()

-- Cari Remote Events
local net = ReplicatedStorage:WaitForChild("Packages"):WaitForChild("_Index"):WaitForChild("sleitnick_net@0.2.0"):WaitForChild("net")
local equipRemote = net:WaitForChild("RE/EquipToolFromHotbar")
local rodRemote = net:WaitForChild("RF/ChargeFishingRod")
local miniGameRemote = net:WaitForChild("RF/RequestFishingMinigameStarted")
local finishRemote = net:WaitForChild("RE/FishingCompleted")

-- Variabel utama
local AutoFish = {
    Enabled = false,
    PerfectCast = false,
    AutoSell = false,
    AntiAFK = false,
    Delay = 2,
    FishCount = 0,
    LastSellTime = 0
}

-- Config Auto Sell
local AUTO_SELL_THRESHOLD = 60
local AUTO_SELL_DELAY = 60

-- UI Library sederhana
local UILibrary = {}
function UILibrary:CreateWindow(name)
    local ScreenGui = Instance.new("ScreenGui")
    local MainFrame = Instance.new("Frame")
    local Title = Instance.new("TextLabel")
    local Container = Instance.new("Frame")
    local UIListLayout = Instance.new("UIListLayout")
    
    ScreenGui.Parent = game.CoreGui
    ScreenGui.Name = "AutoFishGUI"
    
    MainFrame.Name = "MainFrame"
    MainFrame.Parent = ScreenGui
    MainFrame.BackgroundColor3 = Color3.fromRGB(30, 30, 40)
    MainFrame.BorderSizePixel = 0
    MainFrame.Position = UDim2.new(0.02, 0, 0.02, 0)
    MainFrame.Size = UDim2.new(0, 300, 0, 400)
    MainFrame.Active = true
    MainFrame.Draggable = true
    
    Title.Name = "Title"
    Title.Parent = MainFrame
    Title.BackgroundColor3 = Color3.fromRGB(45, 45, 55)
    Title.BorderSizePixel = 0
    Title.Size = UDim2.new(1, 0, 0, 30)
    Title.Font = Enum.Font.GothamBold
    Title.Text = "🎣 " .. name
    Title.TextColor3 = Color3.fromRGB(255, 255, 255)
    Title.TextSize = 14
    
    Container.Name = "Container"
    Container.Parent = MainFrame
    Container.BackgroundColor3 = Color3.fromRGB(30, 30, 40)
    Container.BorderSizePixel = 0
    Container.Position = UDim2.new(0, 0, 0, 30)
    Container.Size = UDim2.new(1, 0, 1, -30)
    
    UIListLayout.Parent = Container
    UIListLayout.HorizontalAlignment = Enum.HorizontalAlignment.Center
    UIListLayout.SortOrder = Enum.SortOrder.LayoutOrder
    UIListLayout.Padding = UDim.new(0, 5)
    
    local window = {}
    
    function window:CreateSection(name)
        local Section = Instance.new("TextLabel")
        Section.Name = "Section"
        Section.Parent = Container
        Section.BackgroundColor3 = Color3.fromRGB(40, 40, 50)
        Section.BorderSizePixel = 0
        Section.Size = UDim2.new(0.9, 0, 0, 25)
        Section.Font = Enum.Font.Gotham
        Section.Text = " " .. name
        Section.TextColor3 = Color3.fromRGB(255, 255, 255)
        Section.TextSize = 12
        Section.TextXAlignment = Enum.TextXAlignment.Left
        
        return Section
    end
    
    function window:CreateToggle(config)
        local ToggleFrame = Instance.new("Frame")
        local ToggleButton = Instance.new("TextButton")
        local Status = Instance.new("TextLabel")
        
        ToggleFrame.Name = "ToggleFrame"
        ToggleFrame.Parent = Container
        ToggleFrame.BackgroundColor3 = Color3.fromRGB(30, 30, 40)
        ToggleFrame.BorderSizePixel = 0
        ToggleFrame.Size = UDim2.new(0.9, 0, 0, 25)
        
        ToggleButton.Name = "ToggleButton"
        ToggleButton.Parent = ToggleFrame
        ToggleButton.BackgroundColor3 = Color3.fromRGB(60, 60, 70)
        ToggleButton.BorderSizePixel = 0
        ToggleButton.Position = UDim2.new(0, 0, 0, 0)
        ToggleButton.Size = UDim2.new(0.7, 0, 1, 0)
        ToggleButton.Font = Enum.Font.Gotham
        ToggleButton.Text = config.Name
        ToggleButton.TextColor3 = Color3.fromRGB(255, 255, 255)
        ToggleButton.TextSize = 12
        ToggleButton.TextXAlignment = Enum.TextXAlignment.Left
        
        Status.Name = "Status"
        Status.Parent = ToggleFrame
        Status.BackgroundColor3 = config.CurrentValue and Color3.fromRGB(0, 170, 0) or Color3.fromRGB(170, 0, 0)
        Status.BorderSizePixel = 0
        Status.Position = UDim2.new(0.75, 0, 0.2, 0)
        Status.Size = UDim2.new(0.2, 0, 0.6, 0)
        Status.Font = Enum.Font.Gotham
        Status.Text = config.CurrentValue and "ON" or "OFF"
        Status.TextColor3 = Color3.fromRGB(255, 255, 255)
        Status.TextSize = 10
        
        ToggleButton.MouseButton1Click:Connect(function()
            config.CurrentValue = not config.CurrentValue
            Status.BackgroundColor3 = config.CurrentValue and Color3.fromRGB(0, 170, 0) or Color3.fromRGB(170, 0, 0)
            Status.Text = config.CurrentValue and "ON" or "OFF"
            config.Callback(config.CurrentValue)
        end)
        
        return ToggleFrame
    end
    
    function window:CreateSlider(config)
        local SliderFrame = Instance.new("Frame")
        local SliderTitle = Instance.new("TextLabel")
        local SliderBar = Instance.new("Frame")
        local SliderFill = Instance.new("Frame")
        local SliderButton = Instance.new("TextButton")
        local ValueLabel = Instance.new("TextLabel")
        
        SliderFrame.Name = "SliderFrame"
        SliderFrame.Parent = Container
        SliderFrame.BackgroundColor3 = Color3.fromRGB(30, 30, 40)
        SliderFrame.BorderSizePixel = 0
        SliderFrame.Size = UDim2.new(0.9, 0, 0, 40)
        
        SliderTitle.Name = "SliderTitle"
        SliderTitle.Parent = SliderFrame
        SliderTitle.BackgroundColor3 = Color3.fromRGB(30, 30, 40)
        SliderTitle.BorderSizePixel = 0
        SliderTitle.Position = UDim2.new(0, 0, 0, 0)
        SliderTitle.Size = UDim2.new(1, 0, 0, 15)
        SliderTitle.Font = Enum.Font.Gotham
        SliderTitle.Text = config.Name .. ": " .. config.CurrentValue
        SliderTitle.TextColor3 = Color3.fromRGB(255, 255, 255)
        SliderTitle.TextSize = 11
        
        SliderBar.Name = "SliderBar"
        SliderBar.Parent = SliderFrame
        SliderBar.BackgroundColor3 = Color3.fromRGB(60, 60, 70)
        SliderBar.BorderSizePixel = 0
        SliderBar.Position = UDim2.new(0, 0, 0.5, 0)
        SliderBar.Size = UDim2.new(1, 0, 0, 5)
        
        SliderFill.Name = "SliderFill"
        SliderFill.Parent = SliderBar
        SliderFill.BackgroundColor3 = Color3.fromRGB(0, 170, 255)
        SliderFill.BorderSizePixel = 0
        SliderFill.Size = UDim2.new((config.CurrentValue - config.Range[1]) / (config.Range[2] - config.Range[1]), 0, 1, 0)
        
        SliderButton.Name = "SliderButton"
        SliderButton.Parent = SliderBar
        SliderButton.BackgroundColor3 = Color3.fromRGB(255, 255, 255)
        SliderButton.BorderSizePixel = 0
        SliderButton.Position = UDim2.new((config.CurrentValue - config.Range[1]) / (config.Range[2] - config.Range[1]), -5, -1.5, 0)
        SliderButton.Size = UDim2.new(0, 10, 0, 10)
        SliderButton.Font = Enum.Font.SourceSans
        SliderButton.Text = ""
        SliderButton.TextColor3 = Color3.fromRGB(0, 0, 0)
        SliderButton.TextSize = 14
        
        ValueLabel.Name = "ValueLabel"
        ValueLabel.Parent = SliderFrame
        ValueLabel.BackgroundColor3 = Color3.fromRGB(30, 30, 40)
        ValueLabel.BorderSizePixel = 0
        ValueLabel.Position = UDim2.new(0, 0, 0.7, 0)
        ValueLabel.Size = UDim2.new(1, 0, 0, 15)
        ValueLabel.Font = Enum.Font.Gotham
        ValueLabel.Text = tostring(config.CurrentValue)
        ValueLabel.TextColor3 = Color3.fromRGB(255, 255, 255)
        ValueLabel.TextSize = 11
        
        local function updateValue(value)
            local clamped = math.clamp(value, config.Range[1], config.Range[2])
            local tween = TweenService:Create(SliderFill, TweenInfo.new(0.1), {Size = UDim2.new((clamped - config.Range[1]) / (config.Range[2] - config.Range[1]), 0, 1, 0)})
            local tween2 = TweenService:Create(SliderButton, TweenInfo.new(0.1), {Position = UDim2.new((clamped - config.Range[1]) / (config.Range[2] - config.Range[1]), -5, -1.5, 0)})
            tween:Play()
            tween2:Play()
            SliderTitle.Text = config.Name .. ": " .. clamped
            ValueLabel.Text = tostring(clamped)
            config.Callback(clamped)
        end
        
        local dragging = false
        SliderButton.MouseButton1Down:Connect(function()
            dragging = true
        end)
        
        UserInputService.InputEnded:Connect(function(input)
            if input.UserInputType == Enum.UserInputType.MouseButton1 then
                dragging = false
            end
        end)
        
        mouse.Move:Connect(function()
            if dragging then
                local pos = UDim2.new(math.clamp((mouse.X - SliderBar.AbsolutePosition.X) / SliderBar.AbsoluteSize.X, 0, 1), 0, -1.5, 0)
                local value = math.floor(config.Range[1] + (pos.X.Scale * (config.Range[2] - config.Range[1])))
                updateValue(value)
            end
        end)
        
        return SliderFrame
    end
    
    function window:CreateButton(config)
        local Button = Instance.new("TextButton")
        
        Button.Name = "Button"
        Button.Parent = Container
        Button.BackgroundColor3 = Color3.fromRGB(60, 60, 70)
        Button.BorderSizePixel = 0
        Button.Size = UDim2.new(0.9, 0, 0, 25)
        Button.Font = Enum.Font.Gotham
        Button.Text = config.Name
        Button.TextColor3 = Color3.fromRGB(255, 255, 255)
        Button.TextSize = 12
        
        Button.MouseButton1Click:Connect(config.Callback)
        
        return Button
    end
    
    function window:CreateLabel(text)
        local Label = Instance.new("TextLabel")
        
        Label.Name = "Label"
        Label.Parent = Container
        Label.BackgroundColor3 = Color3.fromRGB(30, 30, 40)
        Label.BorderSizePixel = 0
        Label.Size = UDim2.new(0.9, 0, 0, 20)
        Label.Font = Enum.Font.Gotham
        Label.Text = text
        Label.TextColor3 = Color3.fromRGB(255, 255, 255)
        Label.TextSize = 11
        
        return Label
    end
    
    return window
end

-- Fungsi Auto Fish
local function AutoFishCycle()
    pcall(function()
        -- Equip fishing rod
        equipRemote:FireServer(1)
        task.wait(0.1)

        -- Charge rod dengan perfect/random cast
        local timestamp = AutoFish.PerfectCast and 9999999999 or (tick() + math.random())
        rodRemote:InvokeServer(timestamp)
        task.wait(0.5)

        -- Cast dengan koordinat perfect/random
        local x = AutoFish.PerfectCast and -1.238 or (math.random(-1000,1000)/1000)
        local y = AutoFish.PerfectCast and 0.969 or (math.random(0,1000)/1000)
        miniGameRemote:InvokeServer(x, y)

        -- Deteksi ikan dengan event-based system
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
            
            -- Safety timeout 15 detik
            local timer = 0
            while not caught and timer < 15 do
                task.wait(0.1)
                timer = timer + 0.1
            end
        else
            task.wait(5) -- Fallback delay
        end

        -- Complete fishing process
        finishRemote:FireServer()
        task.wait(0.1)
        finishRemote:FireServer()

        -- Update fish counter
        AutoFish.FishCount = AutoFish.FishCount + 1
        if FishCounter then
            FishCounter:SetText("🎣 Fish Caught: " .. AutoFish.FishCount)
        end
    end)
end

-- Fungsi Anti AFK
local function StartAntiAFK()
    task.spawn(function()
        while AutoFish.AntiAFK do
            pcall(function()
                VirtualUser:CaptureController()
                VirtualUser:ClickButton2(Vector2.new())
            end)
            task.wait(30)
        end
    end)
end

-- Fungsi Auto Sell
local function StartAutoSell()
    task.spawn(function()
        while AutoFish.AutoSell do
            pcall(function()
                -- Cari sell function
                local sellFunc = net:FindFirstChild("RF/SellAllItems")
                if sellFunc then
                    -- Check delay
                    if os.time() - AutoFish.LastSellTime >= AUTO_SELL_DELAY then
                        sellFunc:InvokeServer()
                        AutoFish.LastSellTime = os.time()
                        print("[Auto Sell] Items sold at " .. os.date("%X"))
                    end
                end
            end)
            task.wait(10) -- Check setiap 10 detik
        end
    end)
end

-- Main Loop Auto Fish
task.spawn(function()
    while true do
        if AutoFish.Enabled then
            AutoFishCycle()
            task.wait(AutoFish.Delay)
        else
            task.wait(1)
        end
    end
end)

-- Buat UI
local Window = UILibrary:CreateWindow("Auto Fish v2.0")

-- Section Main Controls
Window:CreateSection("🎣 Main Controls")
FishCounter = Window:CreateLabel("🎣 Fish Caught: 0")

Window:CreateToggle({
    Name = "Enable Auto Fishing",
    CurrentValue = AutoFish.Enabled,
    Callback = function(value)
        AutoFish.Enabled = value
        print("[Auto Fish] " .. (value and "Enabled" or "Disabled"))
    end
})

Window:CreateToggle({
    Name = "Perfect Cast",
    CurrentValue = AutoFish.PerfectCast,
    Callback = function(value)
        AutoFish.PerfectCast = value
        print("[Perfect Cast] " .. (value and "Enabled" or "Disabled"))
    end
})

Window:CreateSlider({
    Name = "Cast Delay",
    Range = {0.5, 5},
    CurrentValue = AutoFish.Delay,
    Callback = function(value)
        AutoFish.Delay = value
        print("[Delay] Set to " .. value .. " seconds")
    end
})

-- Section Auto Features
Window:CreateSection("⚡ Auto Features")

Window:CreateToggle({
    Name = "Auto Sell Items",
    CurrentValue = AutoFish.AutoSell,
    Callback = function(value)
        AutoFish.AutoSell = value
        if value then
            StartAutoSell()
        end
        print("[Auto Sell] " .. (value and "Enabled" or "Disabled"))
    end
})

Window:CreateToggle({
    Name = "Anti AFK",
    CurrentValue = AutoFish.AntiAFK,
    Callback = function(value)
        AutoFish.AntiAFK = value
        if value then
            StartAntiAFK()
        end
        print("[Anti AFK] " .. (value and "Enabled" or "Disabled"))
    end
})

-- Section Utilities
Window:CreateSection("🔧 Utilities")

Window:CreateButton({
    Name = "Manual Sell Now",
    Callback = function()
        pcall(function()
            local sellFunc = net:FindFirstChild("RF/SellAllItems")
            if sellFunc then
                sellFunc:InvokeServer()
                AutoFish.LastSellTime = os.time()
                print("[Manual Sell] Items sold successfully")
            end
        end)
    end
})

Window:CreateButton({
    Name = "Reset Fish Counter",
    Callback = function()
        AutoFish.FishCount = 0
        FishCounter:SetText("🎣 Fish Caught: 0")
        print("[Counter] Reset to 0")
    end
})

Window:CreateButton({
    Name = "Close GUI",
    Callback = function()
        game.CoreGui.AutoFishGUI:Destroy()
        print("[GUI] Closed")
    end
})

-- Notifikasi startup
print("🎣 Auto Fish Script Loaded!")
print("✅ Features: Auto Fishing, Perfect Cast, Auto Sell, Anti AFK")
print("📍 Controls: Drag the window to move")

-- Setup fishing monitor
task.spawn(function()
    -- Monitor fishing results
    finishRemote.OnClientEvent:Connect(function(result)
        if result and result.Success then
            print("[Fishing] Successfully caught a fish!")
        end
    end)
end)
