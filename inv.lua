-- Script Client untuk Invisibility dengan UI Toggle
local Players = game:GetService("Players")
local ReplicatedStorage = game:GetService("ReplicatedStorage")
local TweenService = game:GetService("TweenService")
local RunService = game:GetService("RunService")

local player = Players.LocalPlayer
local toggleEvent = ReplicatedStorage:WaitForChild("ToggleInvisibility")

local isInvisible = false
local localEffects = {}
local guiElements = {}

-- Buat efek visual lokal
local function createLocalVisualEffect(character)
    -- Hapus efek lama
    for _, effect in pairs(localEffects) do
        if effect then effect:Destroy() end
    end
    localEffects = {}
    
    if not isInvisible then return end
    
    -- Warna untuk efek
    local effectColor = Color3.fromRGB(0, 170, 255)
    
    -- Buat outline untuk setiap part
    for _, part in ipairs(character:GetDescendants()) do
        if part:IsA("BasePart") and part.Name ~= "HumanoidRootPart" then
            local ghostPart = Instance.new("Part")
            ghostPart.Name = "GhostEffect"
            ghostPart.Size = part.Size + Vector3.new(0.05, 0.05, 0.05)
            ghostPart.Transparency = 0.3
            ghostPart.Color = effectColor
            ghostPart.Material = Enum.Material.Neon
            ghostPart.CanCollide = false
            ghostPart.CanTouch = false
            ghostPart.CastShadow = false
            ghostPart.Parent = workspace
            
            -- Weld ke part asli
            local weld = Instance.new("Weld")
            weld.Part0 = part
            weld.Part1 = ghostPart
            weld.C0 = CFrame.new()
            weld.C1 = CFrame.new()
            weld.Parent = ghostPart
            
            table.insert(localEffects, ghostPart)
        end
    end
    
    -- Buat floating indicator
    local rootPart = character:FindFirstChild("HumanoidRootPart")
    if rootPart then
        local indicator = Instance.new("BillboardGui")
        indicator.Name = "LocalIndicator"
        indicator.Adornee = rootPart
        indicator.Size = UDim2.new(0, 100, 0, 40)
        indicator.StudsOffset = Vector3.new(0, 3.5, 0)
        indicator.AlwaysOnTop = true
        indicator.Parent = rootPart
        
        local frame = Instance.new("Frame")
        frame.Size = UDim2.new(1, 0, 1, 0)
        frame.BackgroundTransparency = 1
        frame.Parent = indicator
        
        local text = Instance.new("TextLabel")
        text.Text = "INVISIBLE MODE"
        text.Size = UDim2.new(1, 0, 1, 0)
        text.BackgroundTransparency = 1
        text.TextColor3 = effectColor
        text.Font = Enum.Font.GothamBold
        text.TextSize = 14
        text.Parent = frame
        
        table.insert(localEffects, indicator)
    end
end

-- Buat GUI lengkap dengan toggle button
local function createGUI()
    local screenGui = Instance.new("ScreenGui")
    screenGui.Name = "InvisibilityGUI"
    screenGui.ResetOnSpawn = false
    screenGui.ZIndexBehavior = Enum.ZIndexBehavior.Sibling
    screenGui.Parent = player:WaitForChild("PlayerGui")
    
    -- Background utama
    local mainFrame = Instance.new("Frame")
    mainFrame.Name = "MainFrame"
    mainFrame.Size = UDim2.new(0, 280, 0, 220)
    mainFrame.Position = UDim2.new(0.5, -140, 0.5, -110)
    mainFrame.BackgroundColor3 = Color3.fromRGB(15, 15, 15)
    mainFrame.BackgroundTransparency = 0.1
    mainFrame.BorderSizePixel = 0
    mainFrame.AnchorPoint = Vector2.new(0.5, 0.5)
    mainFrame.Parent = screenGui
    
    local corner = Instance.new("UICorner")
    corner.CornerRadius = UDim.new(0, 12)
    corner.Parent = mainFrame
    
    local stroke = Instance.new("UIStroke")
    stroke.Color = Color3.fromRGB(40, 40, 40)
    stroke.Thickness = 3
    stroke.Parent = mainFrame
    
    -- Header
    local header = Instance.new("Frame")
    header.Name = "Header"
    header.Size = UDim2.new(1, 0, 0, 50)
    header.BackgroundColor3 = Color3.fromRGB(25, 25, 25)
    header.BackgroundTransparency = 0.2
    header.BorderSizePixel = 0
    header.Parent = mainFrame
    
    local headerCorner = Instance.new("UICorner")
    headerCorner.CornerRadius = UDim.new(0, 12)
    headerCorner.Parent = header
    
    local title = Instance.new("TextLabel")
    title.Name = "Title"
    title.Text = "GHOST MODE SYSTEM"
    title.Size = UDim2.new(1, 0, 1, 0)
    title.BackgroundTransparency = 1
    title.TextColor3 = Color3.fromRGB(0, 200, 255)
    title.Font = Enum.Font.GothamBlack
    title.TextSize = 20
    title.Parent = header
    
    -- Status panel
    local statusPanel = Instance.new("Frame")
    statusPanel.Name = "StatusPanel"
    statusPanel.Size = UDim2.new(1, -40, 0, 80)
    statusPanel.Position = UDim2.new(0, 20, 0, 70)
    statusPanel.BackgroundColor3 = Color3.fromRGB(30, 30, 30)
    statusPanel.BackgroundTransparency = 0.3
    statusPanel.BorderSizePixel = 0
    statusPanel.Parent = mainFrame
    
    local statusCorner = Instance.new("UICorner")
    statusCorner.CornerRadius = UDim.new(0, 8)
    statusCorner.Parent = statusPanel
    
    -- Status icon
    local statusIcon = Instance.new("Frame")
    statusIcon.Name = "StatusIcon"
    statusIcon.Size = UDim2.new(0, 20, 0, 20)
    statusIcon.Position = UDim2.new(0, 15, 0.5, -10)
    statusIcon.BackgroundColor3 = Color3.fromRGB(255, 50, 50)
    statusIcon.Parent = statusPanel
    
    local iconCorner = Instance.new("UICorner")
    iconCorner.CornerRadius = UDim.new(1, 0)
    iconCorner.Parent = statusIcon
    
    -- Status text
    local statusText = Instance.new("TextLabel")
    statusText.Name = "StatusText"
    statusText.Text = "STATUS: VISIBLE\nNAMETAG: ON"
    statusText.Size = UDim2.new(1, -50, 1, 0)
    statusText.Position = UDim2.new(0, 45, 0, 0)
    statusText.BackgroundTransparency = 1
    statusText.TextColor3 = Color3.fromRGB(255, 255, 255)
    statusText.Font = Enum.Font.GothamSemibold
    statusText.TextSize = 16
    statusText.TextXAlignment = Enum.TextXAlignment.Left
    statusText.TextYAlignment = Enum.TextYAlignment.Top
    statusText.Parent = statusPanel
    
    -- Toggle button
    local toggleButton = Instance.new("TextButton")
    toggleButton.Name = "ToggleButton"
    toggleButton.Text = "ACTIVATE GHOST MODE"
    toggleButton.Size = UDim2.new(1, -40, 0, 50)
    toggleButton.Position = UDim2.new(0, 20, 0, 170)
    toggleButton.BackgroundColor3 = Color3.fromRGB(0, 120, 215)
    toggleButton.TextColor3 = Color3.fromRGB(255, 255, 255)
    toggleButton.Font = Enum.Font.GothamBold
    toggleButton.TextSize = 18
    toggleButton.AutoButtonColor = true
    toggleButton.Parent = mainFrame
    
    local buttonCorner = Instance.new("UICorner")
    buttonCorner.CornerRadius = UDim.new(0, 8)
    buttonCorner.Parent = toggleButton
    
    local buttonStroke = Instance.new("UIStroke")
    buttonStroke.Color = Color3.fromRGB(0, 150, 255)
    buttonStroke.Thickness = 2
    buttonStroke.Parent = toggleButton
    
    -- Close button (untuk minimize GUI)
    local closeButton = Instance.new("TextButton")
    closeButton.Name = "CloseButton"
    closeButton.Text = "X"
    closeButton.Size = UDim2.new(0, 30, 0, 30)
    closeButton.Position = UDim2.new(1, -35, 0, 10)
    closeButton.BackgroundColor3 = Color3.fromRGB(40, 40, 40)
    closeButton.TextColor3 = Color3.fromRGB(255, 100, 100)
    closeButton.Font = Enum.Font.GothamBlack
    closeButton.TextSize = 16
    closeButton.Parent = mainFrame
    
    local closeCorner = Instance.new("UICorner")
    closeCorner.CornerRadius = UDim.new(1, 0)
    closeCorner.Parent = closeButton
    
    -- Mini button (untuk show GUI kembali)
    local miniButton = Instance.new("TextButton")
    miniButton.Name = "MiniButton"
    miniButton.Text = "👻"
    miniButton.Size = UDim2.new(0, 50, 0, 50)
    miniButton.Position = UDim2.new(0, 20, 0, 20)
    miniButton.BackgroundColor3 = Color3.fromRGB(0, 120, 215)
    miniButton.TextColor3 = Color3.fromRGB(255, 255, 255)
    miniButton.Font = Enum.Font.GothamBold
    miniButton.TextSize = 24
    miniButton.Visible = false
    miniButton.Parent = screenGui
    
    local miniCorner = Instance.new("UICorner")
    miniCorner.CornerRadius = UDim.new(1, 0)
    miniCorner.Parent = miniButton
    
    -- Speed control panel
    local speedPanel = Instance.new("Frame")
    speedPanel.Name = "SpeedPanel"
    speedPanel.Size = UDim2.new(1, -40, 0, 40)
    speedPanel.Position = UDim2.new(0, 20, 0, 120)
    speedPanel.BackgroundColor3 = Color3.fromRGB(30, 30, 30)
    speedPanel.BackgroundTransparency = 0.3
    speedPanel.BorderSizePixel = 0
    speedPanel.Visible = false
    speedPanel.Parent = mainFrame
    
    local speedCorner = Instance.new("UICorner")
    speedCorner.CornerRadius = UDim.new(0, 8)
    speedCorner.Parent = speedPanel
    
    local speedTitle = Instance.new("TextLabel")
    speedTitle.Name = "SpeedTitle"
    speedTitle.Text = "SPEED CONTROL"
    speedTitle.Size = UDim2.new(1, 0, 0, 20)
    speedTitle.BackgroundTransparency = 1
    speedTitle.TextColor3 = Color3.fromRGB(200, 200, 200)
    speedTitle.Font = Enum.Font.Gotham
    speedTitle.TextSize = 12
    speedTitle.Parent = speedPanel
    
    local speedButtons = Instance.new("Frame")
    speedButtons.Name = "SpeedButtons"
    speedButtons.Size = UDim2.new(1, 0, 0, 20)
    speedButtons.Position = UDim2.new(0, 0, 0, 20)
    speedButtons.BackgroundTransparency = 1
    speedButtons.Parent = speedPanel
    
    local speedUpButton = Instance.new("TextButton")
    speedUpButton.Name = "SpeedUpButton"
    speedUpButton.Text = "FAST"
    speedUpButton.Size = UDim2.new(0.45, 0, 1, 0)
    speedUpButton.Position = UDim2.new(0, 5, 0, 0)
    speedUpButton.BackgroundColor3 = Color3.fromRGB(0, 150, 0)
    speedUpButton.TextColor3 = Color3.fromRGB(255, 255, 255)
    speedUpButton.Font = Enum.Font.Gotham
    speedUpButton.TextSize = 12
    speedUpButton.Parent = speedButtons
    
    local speedResetButton = Instance.new("TextButton")
    speedResetButton.Name = "SpeedResetButton"
    speedResetButton.Text = "NORMAL"
    speedResetButton.Size = UDim2.new(0.45, 0, 1, 0)
    speedResetButton.Position = UDim2.new(0.55, 0, 0, 0)
    speedResetButton.BackgroundColor3 = Color3.fromRGB(150, 150, 150)
    speedResetButton.TextColor3 = Color3.fromRGB(255, 255, 255)
    speedResetButton.Font = Enum.Font.Gotham
    speedResetButton.TextSize = 12
    speedResetButton.Parent = speedButtons
    
    -- Simpan elemen GUI
    guiElements = {
        screenGui = screenGui,
        mainFrame = mainFrame,
        statusIcon = statusIcon,
        statusText = statusText,
        toggleButton = toggleButton,
        closeButton = closeButton,
        miniButton = miniButton,
        speedPanel = speedPanel,
        speedUpButton = speedUpButton,
        speedResetButton = speedResetButton
    }
    
    return screenGui
end

-- Update GUI status
local function updateGUIStatus()
    if not guiElements.statusIcon or not guiElements.statusText then return end
    
    if isInvisible then
        guiElements.statusIcon.BackgroundColor3 = Color3.fromRGB(0, 200, 0)
        guiElements.statusText.Text = "STATUS: INVISIBLE\nNAMETAG: HIDDEN"
        guiElements.statusText.TextColor3 = Color3.fromRGB(0, 200, 0)
        guiElements.toggleButton.Text = "DEACTIVATE GHOST MODE"
        guiElements.toggleButton.BackgroundColor3 = Color3.fromRGB(200, 50, 50)
        guiElements.speedPanel.Visible = true
    else
        guiElements.statusIcon.BackgroundColor3 = Color3.fromRGB(255, 50, 50)
        guiElements.statusText.Text = "STATUS: VISIBLE\nNAMETAG: ON"
        guiElements.statusText.TextColor3 = Color3.fromRGB(255, 255, 255)
        guiElements.toggleButton.Text = "ACTIVATE GHOST MODE"
        guiElements.toggleButton.BackgroundColor3 = Color3.fromRGB(0, 120, 215)
        guiElements.speedPanel.Visible = false
    end
end

-- Setup button events
local function setupButtonEvents()
    -- Toggle button event
    guiElements.toggleButton.MouseButton1Click:Connect(function()
        isInvisible = not isInvisible
        
        -- Kirim ke server
        toggleEvent:FireServer(isInvisible)
        
        -- Update GUI
        updateGUIStatus()
        
        -- Buat/hapus efek lokal
        local character = player.Character
        if character then
            if isInvisible then
                createLocalVisualEffect(character)
            else
                for _, effect in pairs(localEffects) do
                    if effect then effect:Destroy() end
                end
                localEffects = {}
            end
        end
    end)
    
    -- Close button event (minimize)
    guiElements.closeButton.MouseButton1Click:Connect(function()
        guiElements.mainFrame.Visible = false
        guiElements.miniButton.Visible = true
    end)
    
    -- Mini button event (show kembali)
    guiElements.miniButton.MouseButton1Click:Connect(function()
        guiElements.mainFrame.Visible = true
        guiElements.miniButton.Visible = false
    end)
    
    -- Speed up button event
    guiElements.speedUpButton.MouseButton1Click:Connect(function()
        local character = player.Character
        if character and isInvisible then
            local humanoid = character:FindFirstChild("Humanoid")
            if humanoid then
                humanoid.WalkSpeed = 60
                humanoid.JumpPower = 80
                guiElements.speedUpButton.BackgroundColor3 = Color3.fromRGB(0, 200, 0)
                guiElements.speedResetButton.BackgroundColor3 = Color3.fromRGB(150, 150, 150)
            end
        end
    end)
    
    -- Speed reset button event
    guiElements.speedResetButton.MouseButton1Click:Connect(function()
        local character = player.Character
        if character and isInvisible then
            local humanoid = character:FindFirstChild("Humanoid")
            if humanoid then
                humanoid.WalkSpeed = 16
                humanoid.JumpPower = 50
                guiElements.speedUpButton.BackgroundColor3 = Color3.fromRGB(0, 150, 0)
                guiElements.speedResetButton.BackgroundColor3 = Color3.fromRGB(200, 150, 0)
            end
        end
    end)
    
    -- Drag functionality untuk main frame
    local dragging = false
    local dragInput, dragStart, startPos
    
    local function update(input)
        local delta = input.Position - dragStart
        guiElements.mainFrame.Position = UDim2.new(
            startPos.X.Scale, 
            startPos.X.Offset + delta.X,
            startPos.Y.Scale, 
            startPos.Y.Offset + delta.Y
        )
    end
    
    guiElements.mainFrame.InputBegan:Connect(function(input)
        if input.UserInputType == Enum.UserInputType.MouseButton1 then
            dragging = true
            dragStart = input.Position
            startPos = guiElements.mainFrame.Position
            
            input.Changed:Connect(function()
                if input.UserInputState == Enum.UserInputState.End then
                    dragging = false
                end
            end)
        end
    end)
    
    guiElements.mainFrame.InputChanged:Connect(function(input)
        if input.UserInputType == Enum.UserInputType.MouseMovement then
            dragInput = input
        end
    end)
    
    game:GetService("UserInputService").InputChanged:Connect(function(input)
        if dragging and input == dragInput then
            update(input)
        end
    end)
end

-- Setup karakter
local function setupCharacter(character)
    -- Tunggu humanoid
    local humanoid = character:WaitForChild("Humanoid", 5)
    
    -- Reset speed
    if humanoid then
        humanoid.WalkSpeed = 16
        humanoid.JumpPower = 50
    end
    
    -- Buat efek jika sedang invisible
    if isInvisible then
        task.wait(0.5)
        createLocalVisualEffect(character)
    end
    
    -- Cleanup efek
    character.AncestryChanged:Connect(function()
        if not character:IsDescendantOf(workspace) then
            for _, effect in pairs(localEffects) do
                if effect then effect:Destroy() end
            end
            localEffects = {}
        end
    end)
end

-- Inisialisasi
local function initialize()
    -- Buat GUI
    createGUI()
    
    -- Setup button events
    setupButtonEvents()
    
    -- Update status awal
    updateGUIStatus()
    
    -- Setup karakter saat ini
    if player.Character then
        setupCharacter(player.Character)
    end
    
    -- Setup karakter baru
    player.CharacterAdded:Connect(function(character)
        setupCharacter(character)
    end)
    
    -- Auto update GUI setiap detik
    while true do
        wait(1)
        updateGUIStatus()
        
        -- Update speed buttons color berdasarkan current speed
        local character = player.Character
        if character and isInvisible then
            local humanoid = character:FindFirstChild("Humanoid")
            if humanoid then
                if humanoid.WalkSpeed > 30 then
                    guiElements.speedUpButton.BackgroundColor3 = Color3.fromRGB(0, 200, 0)
                else
                    guiElements.speedUpButton.BackgroundColor3 = Color3.fromRGB(0, 150, 0)
                end
            end
        end
    end
end

-- Jalankan inisialisasi
task.spawn(initialize)

print("✅ Invisibility System dengan UI Toggle berhasil di-load!")
