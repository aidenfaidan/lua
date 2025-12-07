-- ============================================================--
-- DARKCARBON HUB + Ore ESP (Full Working) - Rayfield Version
-- Hanya Tab Settings + ESP System
-- ============================================================--

-- ===== Load Rayfield =====
local Rayfield = loadstring(game:HttpGet('https://sirius.menu/rayfield'))()

-- ===== Services =====
local Players = game:GetService("Players")
local RunService = game:GetService("RunService")
local Workspace = game:GetService("Workspace")

local player = Players.LocalPlayer
local PlayerGui = player:WaitForChild("PlayerGui")

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

local function GetOreColor(n) 
    return ORE_COLORS[n] or ORE_COLORS.DEFAULT 
end

-- ===== ESP State =====
local ESP_ByHitbox = {} -- [hitbox] = {box, billboard, label, oreName}
local OreToggle = {}    -- per-ore ON/OFF
for k, _ in pairs(ORE_DATA) do 
    OreToggle[k] = false 
end

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

    ESP_ByHitbox[hitbox] = { 
        box = box, 
        billboard = billboard, 
        label = label, 
        oreName = oreName, 
        hitbox = hitbox 
    }
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
            if OreToggle[oreName] then 
                pcall(function() CreateESP(obj) end) 
            end
        end
    end)
    folder.DescendantRemoving:Connect(function(obj)
        if obj:IsA("BasePart") and ESP_ByHitbox[obj] then
            pcall(function() RemoveESP(obj) end)
        end
    end)
end

if ROCK_FOLDER then 
    WatchFolder(ROCK_FOLDER) 
end

Workspace.DescendantAdded:Connect(function(obj)
    if obj.Name == ROCK_FOLDER_NAME and obj:IsA("Folder") then
        ROCK_FOLDER = obj
        for ore, _ in pairs(OreToggle) do 
            if OreToggle[ore] then 
                ScanOre(ore) 
            end 
        end
        WatchFolder(obj)
    end
end)

-- ===== Throttled update =====
local accumulator = 0
local UPDATE_INTERVAL = 0.25
local function UpdateESP()
    local rootPart = player.Character and player.Character:FindFirstChild("HumanoidRootPart")
    for hitbox, data in pairs(ESP_ByHitbox) do
        if not hitbox or not hitbox.Parent then 
            RemoveESP(hitbox) 
        else
            local visible = OreToggle[data.oreName]
            if not visible then 
                RemoveESP(hitbox) 
            else
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
end

RunService.Heartbeat:Connect(function(dt)
    accumulator = accumulator + dt
    if accumulator < UPDATE_INTERVAL then return end
    accumulator = 0
    UpdateESP()
end)

-- ===== GUI SETUP =====
local Window = Rayfield:CreateWindow({
    Name = "DarkCarbon Hub — Ore ESP",
    LoadingTitle = "Loading DarkCarbon ESP...",
    LoadingSubtitle = "By Developer",
    ConfigurationSaving = { 
        Enabled = false,
    },
    Discord = {
        Enabled = false,
    },
    KeySystem = false,
})

-- ===== SETTINGS TAB =====
local SettingsTab = Window:CreateTab("⚙️ Settings")

-- ORE SETTINGS SECTION
SettingsTab:CreateSection("💎 Ore ESP Settings")

-- Sort ore names
local oreNames = {}
for n, _ in pairs(ORE_DATA) do 
    table.insert(oreNames, n) 
end
table.sort(oreNames)

-- Create toggle for each ore
for _, oreName in ipairs(oreNames) do
    SettingsTab:CreateToggle({
        Name = oreName .. " (" .. tostring(ORE_DATA[oreName] or 0) .. " HP)",
        CurrentValue = false,
        Callback = function(val)
            OreToggle[oreName] = val
            if val then
                ScanOre(oreName)
                Rayfield:Notify({
                    Title = "ESP Added",
                    Content = oreName .. " ESP enabled",
                    Duration = 2
                })
            else
                for hitbox, data in pairs(ESP_ByHitbox) do
                    if data.oreName == oreName then 
                        RemoveESP(hitbox) 
                    end
                end
                Rayfield:Notify({
                    Title = "ESP Removed",
                    Content = oreName .. " ESP disabled",
                    Duration = 2
                })
            end
        end
    })
end

-- ===== CHARACTER HANDLING =====
-- Handle character respawn
player.CharacterAdded:Connect(function(character)
    character:WaitForChild("HumanoidRootPart", 10)
    task.wait(1)
    -- Rescan all active ores
    for oreName, state in pairs(OreToggle) do
        if state then
            ScanOre(oreName)
        end
    end
end)

-- ===== INITIALIZATION =====
-- Initial notification
Rayfield:Notify({
    Title = "DarkCarbon Hub Loaded",
    Content = "Ore ESP System Ready!",
    Duration = 3
})

print("=====================================")
print("DarkCarbon Ore ESP System Loaded")
print("Total Ore Types: " .. #oreNames)
print("ESP System: Active")
print("=====================================")
