-- Script: Invisibility Client Controller
-- Tempatkan di StarterPlayerScripts atau StarterCharacterScripts

local Players = game:GetService("Players")
local ReplicatedStorage = game:GetService("ReplicatedStorage")
local UserInputService = game:GetService("UserInputService")
local RunService = game:GetService("RunService")
local TweenService = game:GetService("TweenService")

local player = Players.LocalPlayer
local toggleEvent = ReplicatedStorage:WaitForChild("ToggleInvisibility")

local isInvisible = false
local localEffects = {}
local guiElements = {}

-- Buat GUI
local function createGUI()
    local screenGui = Instance.new("ScreenGui")
    screenGui.Name = "InvisibilitySystemGUI"
    screenGui.ResetOnSpawn = false
    screenGui.ZIndexBehavior = Enum.ZIndexBehavior.Sibling
    screenGui.Parent = player:WaitForChild("PlayerGui")
    
    guiElements.screenGui = screenGui
    
    -- Main container
    local mainFrame = Instance.new("Frame")
    mainFrame.Name = "MainFrame"
    mainFrame.Size = UDim2.new(0, 220, 0, 160)
    mainFrame.Position = UDim2.new(1, -230, 0, 10)
    mainFrame.BackgroundColor3 = Color3.fromRGB(25, 25, 25)
    mainFrame.BackgroundTransparency = 0.2
    mainFrame.BorderSizePixel = 0
    mainFrame.ClipsDescendants = true
    mainFrame.Parent = screenGui
    
    -- Corner
    local corner = Instance.new("UICorner")
    corner.CornerRadius = UDim.new(0, 8)
    corner.Parent = mainFrame
    
    -- Stroke
    local stroke = Instance.new("UIStroke")
    stroke.Color = Color3.fromRGB(60, 60, 60)
    stroke.Thickness = 2
    stroke.Parent = mainFrame
    
    -- Title
    local title = Instance.new("TextLabel")
    title.Name = "Title"
    title.Text = "INVISIBILITY SYSTEM"
    title.Size = UDim2.new(1, 0, 0, 30)
    title.Position = UDim2.new(0, 0, 0, 0)
    title.BackgroundColor3 = Color3.fromRGB(40, 40, 40)
    title.BackgroundTransparency = 0.3
    title.TextColor3 = Color3.fromRGB(0, 170, 255)
    title.Font = Enum.Font.GothamBold
    title.TextSize = 16
    title.Parent = mainFrame
    
    -- Status indicator
    local statusFrame = Instance.new("Frame")
    statusFrame.Name = "StatusFrame"
    statusFrame.Size = UDim2.new(1, -20, 0, 60)
    statusFrame.Position = UDim2.new(0, 10, 0, 40)
    statusFrame.BackgroundTransparency = 1
    statusFrame.Parent = mainFrame
    
    local statusIcon = Instance.new("Frame")
    statusIcon.Name = "StatusIcon"
    statusIcon.Size = UDim2.new(0, 20, 0, 20)
    statusIcon.Position = UDim2.new(0, 0, 0.5, -10)
    statusIcon.BackgroundColor3 = Color3.fromRGB(255, 50, 50)
    statusIcon.Parent = statusFrame
    
    local statusCorner = Instance.new("UICorner")
    statusCorner.CornerRadius = UDim.new(1, 0)
    statusCorner.Parent = statusIcon
    
    local statusText = Instance.new("TextLabel")
    statusText.Name = "StatusText"
    statusText.Text = "STATUS: VISIBLE"
    statusText.Size = UDim2.new(1, -30, 1, 0)
    statusText.Position = UDim2.new(0, 30, 0, 0)
    statusText.BackgroundTransparency = 1
    statusText.TextColor3 = Color3.fromRGB(255, 255, 255)
    statusText.Font = Enum.Font.GothamSemibold
    statusText.TextSize = 14
    statusText.TextXAlignment = Enum.TextXAlignment.Left
    statusText.Parent = statusFrame
    
    -- Keybind info
    local keybindText = Instance.new("TextLabel")
    keybindText.Name = "KeybindText"
    keybindText.Text = "PRESS [ I ] TO TOGGLE"
    keybindText.Size = UDim2.new(1, -20, 0, 20)
    keybindText.Position = UDim2.new(0, 10, 0, 110)
    keybindText.BackgroundTransparency = 1
    keybindText.TextColor3 = Color3.fromRGB(200, 200, 200)
    keybindText.Font = Enum.Font.Gotham
    keybindText.TextSize = 12
    keybindText.Parent = mainFrame
    
    -- Speed info (hidden by default)
    local speedInfo = Instance.new("TextLabel")
    speedInfo.Name = "SpeedInfo"
    speedInfo.Text = "SPEED: NORMAL"
    speedInfo.Size = UDim2.new(1, -20, 0, 20)
    speedInfo.Position = UDim2.new(0, 10, 0, 130)
    speedInfo.BackgroundTransparency = 1
    speedInfo.TextColor3 = Color3.fromRGB(200, 200, 200)
    speedInfo.Font = Enum.Font.Gotham
    speedInfo.TextSize = 11
    speedInfo.Visible = false
    speedInfo.Parent = mainFrame
    
    guiElements.mainFrame = mainFrame
    guiElements.statusIcon = statusIcon
    guiElements.statusText = statusText
    guiElements.speedInfo = speedInfo
    
    return screenGui
end

-- Update GUI status
local function updateGUIStatus(invisible)
    if not guiElements.statusIcon or not guiElements.statusText then return end
    
    if invisible then
        guiElements.statusIcon.BackgroundColor3 = Color3.fromRGB(0, 200, 0)
        guiElements.statusText.Text = "STATUS: INVISIBLE"
        guiElements.statusText.TextColor3 = Color3.fromRGB(0, 200, 0)
        guiElements.speedInfo.Visible = true
        guiElements.speedInfo.Text = "SPEED: INCREASED"
    else
        guiElements.statusIcon.BackgroundColor3 = Color3.fromRGB(255, 50, 50)
        guiElements.statusText.Text = "STATUS: VISIBLE"
        guiElements.statusText.TextColor3 = Color3.fromRGB(255, 255, 255)
        guiElements.speedInfo.Visible = false
    end
end

-- Buat efek visual lokal untuk diri sendiri
local function createLocalEffect(character)
    -- Hapus efek lama
    for _, effect in pairs(localEffects) do
        if effect and effect:IsA("BasePart") then
            effect:Destroy()
        end
    end
    localEffects = {}
    
    if not isInvisible then return end
    
    -- Material dan warna untuk efek
    local effectMaterial = Enum.Material.Neon
    local effectColor = Color3.fromRGB(0, 170, 255)
    
    -- Buat efek untuk setiap part
    for _, part in ipairs(character:GetDescendants()) do
        if part:IsA("BasePart") and part.Name ~= "HumanoidRootPart" then
            -- Buat part transparan
            local ghostPart = Instance.new("Part")
            ghostPart.Name = "Ghost_" .. part.Name
            ghostPart.Size = part.Size
            ghostPart.Transparency = 0.3
            ghostPart.Color = effectColor
            ghostPart.Material = effectMaterial
            ghostPart.CanCollide = false
            ghostPart.CanTouch = false
            ghostPart.CastShadow = false
            ghostPart.Anchored = false
            ghostPart.Parent = workspace
            
            -- Weld ke part asli
            local weld = Instance.new("Weld")
            weld.Part0 = part
            weld.Part1 = ghostPart
            weld.C0 = CFrame.new()
            weld.C1 = CFrame.new()
            weld.Parent = ghostPart
            
            -- Tambahkan light effect
            local pointLight = Instance.new("PointLight")
            pointLight.Brightness = 0.5
            pointLight.Range = 5
            pointLight.Color = effectColor
            pointLight.Parent = ghostPart
            
            table.insert(localEffects, ghostPart)
        end
    end
    
    -- Buat aura effect di sekitar karakter
    local rootPart = character:FindFirstChild("HumanoidRootPart")
    if rootPart then
        local aura = Instance.new("Part")
        aura.Name = "InvisibilityAura"
        aura.Shape = Enum.PartType.Ball
        aura.Size = Vector3.new(8, 8, 8)
        aura.Transparency = 0.8
        aura.Color = Color3.fromRGB(0, 100, 255)
        aura.Material = Enum.Material.Neon
        aura.CanCollide = false
        aura.CanTouch = false
        aura.Anchored = false
        aura.Parent = workspace
        
        local weld = Instance.new("Weld")
        weld.Part0 = rootPart
        weld.Part1 = aura
        weld.C0 = CFrame.new(0, 0, 0)
        weld.Parent = aura
        
        local pointLight = Instance.new("PointLight")
        pointLight.Brightness = 1
        pointLight.Range = 15
        pointLight.Color = Color3.fromRGB(0, 100, 255)
        pointLight.Parent = aura
        
        table.insert(localEffects, aura)
    end
end

-- Handle input
local function setupInput()
    UserInputService.InputBegan:Connect(function(input, gameProcessed)
        if gameProcessed then return end
        
        -- Tombol I untuk toggle invisibility
        if input.KeyCode == Enum.KeyCode.I then
            isInvisible = not isInvisible
            
            -- Kirim ke server
            toggleEvent:FireServer(isInvisible)
            
            -- Update GUI
            updateGUIStatus(isInvisible)
            
            -- Buat/hapus efek lokal
            local character = player.Character
            if character then
                createLocalEffect(character)
            end
            
            -- Play sound effect (optional)
            if isInvisible then
                -- Sound untuk activate
            else
                -- Sound untuk deactivate
            end
        end
        
        -- Tombol O untuk increase speed saat invisible (opsional)
        if isInvisible and input.KeyCode == Enum.KeyCode.O then
            local character = player.Character
            if character then
                local humanoid = character:FindFirstChild("Humanoid")
                if humanoid then
                    humanoid.WalkSpeed = 50 -- Kecepatan meningkat
                    if guiElements.speedInfo then
                        guiElements.speedInfo.Text = "SPEED: FAST (" .. humanoid.WalkSpeed .. ")"
                    end
                end
            end
        end
        
        -- Tombol P untuk reset speed (opsional)
        if isInvisible and input.KeyCode == Enum.KeyCode.P then
            local character = player.Character
            if character then
                local humanoid = character:FindFirstChild("Humanoid")
                if humanoid then
                    humanoid.WalkSpeed = 16 -- Kecepatan normal
                    if guiElements.speedInfo then
                        guiElements.speedInfo.Text = "SPEED: NORMAL"
                    end
                end
            end
        end
    end)
end

-- Setup karakter
local function setupCharacter(character)
    -- Tunggu humanoid
    local humanoid = character:WaitForChild("Humanoid", 5)
    
    -- Reset speed ketika karakter berubah
    if humanoid then
        humanoid.WalkSpeed = 16
    end
    
    -- Buat efek jika sedang invisible
    if isInvisible then
        task.wait(0.5)
        createLocalEffect(character)
    end
    
    -- Cleanup ketika karakter dihapus
    character.AncestryChanged:Connect(function()
        if not character:IsDescendantOf(workspace) then
            for _, effect in pairs(localEffects) do
                if effect then
                    effect:Destroy()
                end
            end
            localEffects = {}
        end
    end)
end

-- Inisialisasi
local function initialize()
    -- Buat GUI
    createGUI()
    
    -- Setup input
    setupInput()
    
    -- Setup karakter saat ini
    if player.Character then
        setupCharacter(player.Character)
    end
    
    -- Setup karakter baru
    player.CharacterAdded:Connect(function(character)
        setupCharacter(character)
    end)
    
    -- Cleanup ketika player keluar
    player.AncestryChanged:Connect(function()
        if not player:IsDescendantOf(game) then
            if guiElements.screenGui then
                guiElements.screenGui:Destroy()
            end
            for _, effect in pairs(localEffects) do
                if effect then
                    effect:Destroy()
                end
            end
        end
    end)
end

-- Jalankan inisialisasi
task.spawn(initialize)

-- Debug info
print("Invisibility System Loaded!")
print("Press I to toggle invisibility")
print("Press O to increase speed while invisible")
print("Press P to reset speed")

-- Return module (optional)
return {
    toggleInvisibility = function(state)
        isInvisible = state or not isInvisible
        toggleEvent:FireServer(isInvisible)
        updateGUIStatus(isInvisible)
        
        local character = player.Character
        if character then
            createLocalEffect(character)
        end
    end,
    
    getStatus = function()
        return isInvisible
    end,
    
    cleanup = function()
        for _, effect in pairs(localEffects) do
            if effect then
                effect:Destroy()
            end
        end
        localEffects = {}
        
        if guiElements.screenGui then
            guiElements.screenGui:Destroy()
        end
    end
}
