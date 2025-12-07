-- ============================================================--
-- DARKCARBON HUB + Ore ESP (Full Working) - Rayfield Version
-- Toggle → Menu dengan Tab (Home / Controls / Settings)
-- ============================================================--

-- ===== Load Rayfield =====
local Rayfield = loadstring(game:HttpGet('https://sirius.menu/rayfield'))()

-- ===== Services =====
local Players = game:GetService("Players")
local RunService = game:GetService("RunService")
local UserInputService = game:GetService("UserInputService")
local TweenService = game:GetService("TweenService")
local Workspace = game:GetService("Workspace")

local player = Players.LocalPlayer
local PlayerGui = player:WaitForChild("PlayerGui")

-- ===== Cleanup old GUIs =====
for _, name in ipairs({ "DarkCarbonUI_Final", "OreESP_Billboards" }) do
    local old = PlayerGui:FindFirstChild(name)
    if old then pcall(function() old:Destroy() end) end
end

-- ===== Helper funcs =====
local function tween(obj, props, t)
    TweenService:Create(obj, TweenInfo.new(t or 0.18, Enum.EasingStyle.Quad, Enum.EasingDirection.Out), props):Play()
end
local function clamp(v, a, b) return math.clamp(v, a, b) end

-- ===== Ore Data =====
local ORE_DATA = {
    ["Pebble"] = 14, ["Rock"] = 45, ["Boulder"] = 100,
    ["Basalt Rock"] = 250, ["Basalt Core"] = 750, ["Basalt Vein"] = 2750,
    ["Volcanic Rock"] = 4500, ["Crimson Crystal"] = 5005,
    ["Earth Crystal"] = 5005, ["Cyan Crystal"] = 5005
}

local ORE_COLORS = {
    ["Pebble"] = Color3.fromRGB(0, 255, 0),
    ["Rock"] = Color3.fromRGB(150, 150, 150),
    ["Boulder"] = Color3.fromRGB(200, 200, 200),
    ["Basalt Rock"] = Color3.fromRGB(70, 70, 70),
    ["Basalt Core"] = Color3.fromRGB(150, 0, 255),
    ["Basalt Vein"] = Color3.fromRGB(90, 0, 180),
    ["Volcanic Rock"] = Color3.fromRGB(255, 80, 0),
    ["Crimson Crystal"] = Color3.fromRGB(255, 0, 60),
    ["Earth Crystal"] = Color3.fromRGB(0, 255, 100),
    ["Cyan Crystal"] = Color3.fromRGB(0, 255, 255),
    DEFAULT = Color3.fromRGB(0, 200, 255)
}

local function GetOreColor(n) return ORE_COLORS[n] or ORE_COLORS.DEFAULT end

-- ===== ESP State =====
local ESP_ByHitbox = {} -- [hitbox] = {box, billboard, label, oreName}
local OreToggle = {}    -- per-ore ON/OFF
for k, _ in pairs(ORE_DATA) do OreToggle[k] = false end

-- Folder rocks
local ROCK_FOLDER_NAME = "Rocks"
local ROCK_FOLDER = Workspace:FindFirstChild(ROCK_FOLDER_NAME)

-- Billboard container
local BillboardGuiContainer = Instance.new("ScreenGui")
BillboardGuiContainer.Name = "OreESP_Billboards"
BillboardGuiContainer.ResetOnSpawn = false
BillboardGuiContainer.Parent = PlayerGui

-- ===== ESP Functions =====
local function GetOreHP(hitbox)
    if not hitbox or not hitbox.Parent then return 0 end
    local model = hitbox.Parent
    local a = hitbox:GetAttribute("Health")
    if type(a) == "number" then return a end
    local b = model:GetAttribute("Health")
    if type(b) == "number" then return b end
    for _, v in ipairs(model:GetDescendants()) do
        if v:IsA("NumberValue") or v:IsA("IntValue") then
            local n = string.lower(v.Name)
            if n == "hp" or n == "health" then return v.Value end
        end
    end
    return ORE_DATA[model.Name] or 0
end

local function CreateESP(hitbox)
    if not hitbox or not hitbox:IsA("BasePart") then return end
    if ESP_ByHitbox[hitbox] then return end
    if not hitbox.Parent then return end
    local oreName = hitbox.Parent.Name
    if not OreToggle[oreName] then return end
    local color = GetOreColor(oreName)

    local box = Instance.new("BoxHandleAdornment")
    box.Name = "OreBox"
    box.Adornee = hitbox
    box.Size = hitbox.Size
    box.Color3 = color
    box.AlwaysOnTop = true
    box.Transparency = 0.5
    box.ZIndex = 5
    box.Parent = hitbox

    local billboard = Instance.new("BillboardGui")
    billboard.Name = "OreBillboard"
    billboard.Adornee = hitbox
    billboard.AlwaysOnTop = true
    billboard.Size = UDim2.new(0, 180, 0, 24)
    billboard.Parent = BillboardGuiContainer

    local label = Instance.new("TextLabel")
    label.Name = "OreLabel"
    label.Size = UDim2.new(1, 0, 1, 0)
    label.BackgroundTransparency = 1
    label.Font = Enum.Font.GothamBold
    label.TextScaled = true
    label.TextColor3 = color
    label.TextStrokeTransparency = 0.6
    label.Parent = billboard

    ESP_ByHitbox[hitbox] = { box = box, billboard = billboard, label = label, oreName = oreName, hitbox = hitbox }
end

local function RemoveESP(hitbox)
    local data = ESP_ByHitbox[hitbox]
    if not data then return end
    pcall(function()
        if data.box and data.box.Parent then data.box:Destroy() end
        if data.billboard and data.billboard.Parent then data.billboard:Destroy() end
    end)
    ESP_ByHitbox[hitbox] = nil
end

local function ScanOre(oreName)
    if not ROCK_FOLDER then return end
    for _, desc in ipairs(ROCK_FOLDER:GetDescendants()) do
        if desc:IsA("BasePart") and desc.Name == "Hitbox" and desc.Parent.Name == oreName then
            pcall(function() CreateESP(desc) end)
        end
    end
end

local function WatchFolder(folder)
    if not folder then return end
    folder.DescendantAdded:Connect(function(obj)
        if obj:IsA("BasePart") and obj.Name == "Hitbox" then
            local oreName = obj.Parent and obj.Parent.Name
            if OreToggle[oreName] then pcall(function() CreateESP(obj) end) end
        end
    end)
    folder.DescendantRemoving:Connect(function(obj)
        if obj:IsA("BasePart") and ESP_ByHitbox[obj] then
            pcall(function() RemoveESP(obj) end)
        end
    end)
end

if ROCK_FOLDER then WatchFolder(ROCK_FOLDER) end
Workspace.DescendantAdded:Connect(function(obj)
    if obj.Name == ROCK_FOLDER_NAME and obj:IsA("Folder") then
        ROCK_FOLDER = obj
        for ore, _ in pairs(OreToggle) do if OreToggle[ore] then ScanOre(ore) end end
        WatchFolder(obj)
    end
end)

-- ===== Throttled update =====
local accumulator = 0
local UPDATE_INTERVAL = 0.25
RunService.Heartbeat:Connect(function(dt)
    accumulator = accumulator + dt
    if accumulator < UPDATE_INTERVAL then return end
    accumulator = 0
    local rootPart = player.Character and player.Character:FindFirstChild("HumanoidRootPart")
    for hitbox, data in pairs(ESP_ByHitbox) do
        if not hitbox or not hitbox.Parent then RemoveESP(hitbox) else
            local visible = OreToggle[data.oreName]
            if not visible then RemoveESP(hitbox) else
                local hp = GetOreHP(hitbox)
                local dist = rootPart and math.floor((rootPart.Position - hitbox.Position).Magnitude) or 0
                if data.label then
                    data.label.Text = string.format("%s | HP: %d | %dm", data.oreName, hp, dist)
                end
                if data.box and data.box.Adornee == hitbox and data.box.Size ~= hitbox.Size then
                    data.box.Size = hitbox.Size
                end
            end
        end
    end
end)

-- ===== Initialize Rayfield Window =====
local Window = Rayfield:CreateWindow({
    Name = "DarkCarbon — Dev UI",
    LoadingTitle = "Loading DarkCarbon Hub...",
    LoadingSubtitle = "by Developer",
    ConfigurationSaving = {
        Enabled = false,
    },
    Discord = {
        Enabled = false,
    },
    KeySystem = false,
})

-- ===== Create Tabs =====
local HomeTab = Window:CreateTab("Home", nil) -- Icon bisa ditambahkan jika ada
local ControlsTab = Window:CreateTab("Controls", nil)
local SettingsTab = Window:CreateTab("Settings", nil)

-- ===== Home Tab Content =====
local HomeSection = HomeTab:CreateSection("Welcome")
HomeTab:CreateLabel("DarkCarbon Hub - Ore ESP System")
HomeTab:CreateLabel("Version: 1.0.0")
HomeTab:CreateLabel("Developer: DarkCarbon")

HomeTab:CreateParagraph({
    Title = "Features",
    Content = "• Ore ESP with health and distance display\n• Color-coded ore types\n• Real-time ore scanning\n• Toggle individual ore types\n• Auto-update ESP when new rocks spawn"
})

local StatsSection = HomeTab:CreateSection("Statistics")
local OreCountLabel = HomeTab:CreateLabel("Total Ore Types: " .. #ORE_DATA)
local ActiveESPCount = HomeTab:CreateLabel("Active ESP: 0")

-- Update active ESP count
local function UpdateESPCount()
    local count = 0
    for _, state in pairs(OreToggle) do
        if state then count = count + 1 end
    end
    ActiveESPCount:Set("Active ESP: " .. count)
end

-- ===== Controls Tab Content =====
local ESPControls = ControlsTab:CreateSection("ESP Controls")

-- Toggle All ESP button
ControlsTab:CreateButton({
    Name = "Toggle All ESP ON",
    Callback = function()
        for oreName, _ in pairs(OreToggle) do
            OreToggle[oreName] = true
            ScanOre(oreName)
        end
        UpdateESPCount()
        Rayfield:Notify({
            Title = "ESP",
            Content = "All ESP toggled ON",
            Duration = 2,
        })
    end,
})

ControlsTab:CreateButton({
    Name = "Toggle All ESP OFF",
    Callback = function()
        for oreName, _ in pairs(OreToggle) do
            OreToggle[oreName] = false
            for hitbox, data in pairs(ESP_ByHitbox) do
                if data.oreName == oreName then RemoveESP(hitbox) end
            end
        end
        UpdateESPCount()
        Rayfield:Notify({
            Title = "ESP",
            Content = "All ESP toggled OFF",
            Duration = 2,
        })
    end,
})

local RefreshButton = ControlsTab:CreateButton({
    Name = "Refresh ESP",
    Callback = function()
        -- Clear all ESP
        for hitbox, _ in pairs(ESP_ByHitbox) do
            RemoveESP(hitbox)
        end
        
        -- Rescan for active ores
        for oreName, state in pairs(OreToggle) do
            if state then ScanOre(oreName) end
        end
        
        Rayfield:Notify({
            Title = "ESP",
            Content = "ESP refreshed",
            Duration = 1,
        })
    end,
})

local UtilitySection = ControlsTab:CreateSection("Utility")
ControlsTab:CreateButton({
    Name = "Clear All ESP",
    Callback = function()
        for hitbox, _ in pairs(ESP_ByHitbox) do
            RemoveESP(hitbox)
        end
        Rayfield:Notify({
            Title = "ESP",
            Content = "All ESP cleared",
            Duration = 2,
        })
    end,
})

-- ===== Settings Tab Content =====
local ESPSettings = SettingsTab:CreateSection("ESP Settings")

-- Create toggle for each ore type
local oreNames = {}
for n, _ in pairs(ORE_DATA) do table.insert(oreNames, n) end
table.sort(oreNames)

local toggleElements = {} -- Simpan toggle untuk nanti update warna

for _, oreName in ipairs(oreNames) do
    local toggle = SettingsTab:CreateToggle({
        Name = oreName .. " (" .. tostring(ORE_DATA[oreName] or 0) .. ")",
        CurrentValue = false,
        Flag = "Toggle_" .. oreName, -- Flag untuk identification
        Callback = function(value)
            OreToggle[oreName] = value
            if value then
                ScanOre(oreName)
                -- Set warna berdasarkan ore
                local oreColor = GetOreColor(oreName)
                -- Tidak ada method Set() di Rayfield untuk toggle, kita hanya update state
            else
                for hitbox, data in pairs(ESP_ByHitbox) do
                    if data.oreName == oreName then RemoveESP(hitbox) end
                end
            end
            UpdateESPCount()
        end,
    })
    
    toggleElements[oreName] = toggle
end

local UISettings = SettingsTab:CreateSection("UI Settings")
SettingsTab:CreateButton({
    Name = "Destroy GUI",
    Callback = function()
        Rayfield:Destroy()
        if BillboardGuiContainer then
            BillboardGuiContainer:Destroy()
        end
    end,
})

SettingsTab:CreateButton({
    Name = "Reset All Settings",
    Callback = function()
        for oreName, _ in pairs(OreToggle) do
            OreToggle[oreName] = false
            for hitbox, data in pairs(ESP_ByHitbox) do
                if data.oreName == oreName then RemoveESP(hitbox) end
            end
        end
        UpdateESPCount()
        Rayfield:Notify({
            Title = "Settings",
            Content = "All settings reset",
            Duration = 2,
        })
    end,
})

-- ===== Additional Features =====
-- Auto-update ESP count periodically
local updateCountConnection = RunService.Heartbeat:Connect(function(dt)
    -- Update setiap 1 detik
    accumulator = accumulator + dt
    if accumulator > 1 then
        accumulator = 0
        UpdateESPCount()
    end
end)

-- Cleanup when GUI is destroyed
local windowDestroyed = false
Rayfield:OnDestroy(function()
    windowDestroyed = true
    if updateCountConnection then
        updateCountConnection:Disconnect()
    end
    if BillboardGuiContainer then
        BillboardGuiContainer:Destroy()
    end
    
    -- Clear all ESP
    for hitbox, _ in pairs(ESP_ByHitbox) do
        RemoveESP(hitbox)
    end
end)

-- Initial notification
Rayfield:Notify({
    Title = "DarkCarbon Hub",
    Content = "Successfully loaded! Check Settings tab for ESP toggles.",
    Duration = 5,
})

-- ===== Character Handling =====
-- Pastikan ESP tetap berjalan saat karakter respawn
player.CharacterAdded:Connect(function(character)
    character:WaitForChild("HumanoidRootPart", 10)
    -- Rescan semua ore yang aktif
    for oreName, state in pairs(OreToggle) do
        if state then
            task.wait(0.5)
            ScanOre(oreName)
        end
    end
end)

print("DarkCarbon UI + OreESP loaded with Rayfield — Use Settings tab to toggle ESP")

-- Fungsi untuk debug: cek apakah window dan tab berjalan
task.wait(1)
print("Rayfield Window initialized:", Window ~= nil)
print("Home Tab created:", HomeTab ~= nil)
print("Controls Tab created:", ControlsTab ~= nil)
print("Settings Tab created:", SettingsTab ~= nil)
