-- ============================================================--
-- DARKCARBON HUB + Ore & Monster ESP (Full Working) - Rayfield Version
-- Hanya Tab Settings + ESP System dengan Highlight
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

-- ===== Monster Data (Base Names) =====
local MONSTER_BASE_NAMES = {
    "Bomber",
    "Skeleton Rogue", 
    "Axe Skeleton",
    "Deathaxe Skeleton",
    "Elite Rogue Skeleton",
    "Elite Deathaxe Skeleton",
    "Zombie",
    "Delver Zombie",
    "Elite Zombie",
    "Brute Zombie",
    "Reaper",
    "Blight Pyromancer",  -- Updated from "Blight Puromancer"
    "Slime",
    "Blazing Slime"       -- Updated from "Burning Slime"
}

local MONSTER_COLORS = {
    ["Bomber"] = Color3.fromRGB(255, 50, 50),
    ["Skeleton Rogue"] = Color3.fromRGB(200, 200, 200),
    ["Axe Skeleton"] = Color3.fromRGB(150, 150, 150),
    ["Deathaxe Skeleton"] = Color3.fromRGB(100, 0, 0),
    ["Elite Rogue Skeleton"] = Color3.fromRGB(255, 215, 0),
    ["Elite Deathaxe Skeleton"] = Color3.fromRGB(255, 100, 0),
    ["Zombie"] = Color3.fromRGB(0, 150, 0),
    ["Delver Zombie"] = Color3.fromRGB(0, 100, 0),
    ["Elite Zombie"] = Color3.fromRGB(0, 200, 0),
    ["Brute Zombie"] = Color3.fromRGB(0, 255, 0),
    ["Reaper"] = Color3.fromRGB(0, 0, 0),
    ["Blight Pyromancer"] = Color3.fromRGB(150, 0, 150),
    ["Slime"] = Color3.fromRGB(0, 150, 255),
    ["Blazing Slime"] = Color3.fromRGB(255, 100, 0),
    DEFAULT = Color3.fromRGB(255, 255, 255)
}

-- ===== Monster Name Matcher System =====
local MonsterPatternCache = {} -- Cache untuk hasil matching

local function GetOreColor(n) 
    return ORE_COLORS[n] or ORE_COLORS.DEFAULT 
end

local function GetMonsterColor(n)
    return MONSTER_COLORS[n] or MONSTER_COLORS.DEFAULT
end

-- Fungsi utama untuk mencocokkan nama monster dengan angka
local function MatchMonsterName(fullName)
    -- Skip jika adalah player (Berserker_Vek atau nama lain dengan underscore)
    if fullName:find("_") then
        return nil
    end
    
    -- Cek cache dulu untuk performa
    if MonsterPatternCache[fullName] then
        return MonsterPatternCache[fullName]
    end
    
    -- Pattern 1: Exact match dengan nama dasar (jika tidak ada angka)
    for _, baseName in ipairs(MONSTER_BASE_NAMES) do
        if fullName == baseName then
            MonsterPatternCache[fullName] = baseName
            return baseName
        end
    end
    
    -- Pattern 2: Nama dasar diikuti angka (tanpa spasi)
    for _, baseName in ipairs(MONSTER_BASE_NAMES) do
        local pattern = "^" .. baseName .. "%d+$"
        if fullName:match(pattern) then
            MonsterPatternCache[fullName] = baseName
            return baseName
        end
    end
    
    -- Pattern 3: Nama dasar diikuti spasi dan angka
    for _, baseName in ipairs(MONSTER_BASE_NAMES) do
        local pattern = "^" .. baseName .. "%s+%d+$"
        if fullName:match(pattern) then
            MonsterPatternCache[fullName] = baseName
            return baseName
        end
    end
    
    -- Pattern 4: Partial match (untuk kasus typo atau variasi kecil)
    for _, baseName in ipairs(MONSTER_BASE_NAMES) do
        -- Cek jika nama dimulai dengan baseName
        if fullName:sub(1, #baseName) == baseName then
            MonsterPatternCache[fullName] = baseName
            return baseName
        end
    end
    
    -- Pattern 5: Fuzzy matching (jika ada perbedaan kecil)
    for _, baseName in ipairs(MONSTER_BASE_NAMES) do
        -- Hitung kemiripan string
        local similarity = 0
        local minLength = math.min(#baseName, #fullName)
        
        for i = 1, minLength do
            if baseName:sub(i, i) == fullName:sub(i, i) then
                similarity = similarity + 1
            end
        end
        
        local similarityRatio = similarity / math.max(#baseName, #fullName)
        if similarityRatio > 0.8 then -- 80% kemiripan
            MonsterPatternCache[fullName] = baseName
            return baseName
        end
    end
    
    -- Tidak ditemukan
    MonsterPatternCache[fullName] = nil
    return nil
end

-- ===== ESP State =====
local ESP_ByHitbox = {} -- [hitbox] = {highlight, billboard, label, oreName}
local OreToggle = {}    -- per-ore ON/OFF
for k, _ in pairs(ORE_DATA) do 
    OreToggle[k] = false 
end

local Monster_ByModel = {} -- [model] = {highlight, billboard, label, baseMonsterName}
local MonsterToggle = {}    -- per-monster ON/OFF
for _, name in ipairs(MONSTER_BASE_NAMES) do
    MonsterToggle[name] = false
end

-- Folder rocks
local ROCK_FOLDER_NAME = "Rocks"
local ROCK_FOLDER = Workspace:FindFirstChild(ROCK_FOLDER_NAME)

-- Folder monsters
local MONSTER_FOLDER_NAME = "Living"
local MONSTER_FOLDER = Workspace:FindFirstChild(MONSTER_FOLDER_NAME)

-- Billboard container
local BillboardGuiContainer = Instance.new("ScreenGui")
BillboardGuiContainer.Name = "OreESP_Billboards"
BillboardGuiContainer.ResetOnSpawn = false
BillboardGuiContainer.Parent = PlayerGui

-- Billboard container monster
local MonsterBillboardContainer = Instance.new("ScreenGui")
MonsterBillboardContainer.Name = "MonsterESP_Billboards"
MonsterBillboardContainer.ResetOnSpawn = false
MonsterBillboardContainer.Parent = PlayerGui

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

local function GetMonsterHP(model)
    if not model or not model:IsA("Model") then return 0 end
    local a = model:GetAttribute("Health")
    if type(a) == "number" then return a end
    for _, v in ipairs(model:GetDescendants()) do
        if v:IsA("NumberValue") or v:IsA("IntValue") then
            local n = string.lower(v.Name)
            if n == "hp" or n == "health" then return v.Value end
        end
    end
    return 0
end

local function GetActualOreModel(hitbox)
    local model = hitbox.Parent
    if model and model:IsA("Model") then
        return model
    end
    local parent = model.Parent
    if parent and parent:IsA("Model") then
        return parent
    end
    return model or hitbox
end

local function GetMonsterHitbox(model)
    -- Cari bagian yang cocok untuk dijadikan adornee billboard
    local hitbox = model:FindFirstChild("Hitbox") or 
                   model:FindFirstChild("Head") or 
                   model:FindFirstChild("HumanoidRootPart") or 
                   model.PrimaryPart
    return hitbox or model
end

-- ===== ORE ESP Functions =====
local function CreateESP(hitbox)
    if not hitbox or not hitbox:IsA("BasePart") then return end
    if ESP_ByHitbox[hitbox] then return end
    if not hitbox.Parent then return end
    local oreName = hitbox.Parent.Name
    if not OreToggle[oreName] then return end
    local color = GetOreColor(oreName)
    
    local oreModel = GetActualOreModel(hitbox)
    
    local highlight = Instance.new("Highlight")
    highlight.Name = "OreHighlight"
    highlight.Adornee = oreModel
    highlight.FillColor = color
    highlight.OutlineColor = color
    highlight.FillTransparency = 0.7
    highlight.OutlineTransparency = 0.3
    highlight.DepthMode = Enum.HighlightDepthMode.AlwaysOnTop
    highlight.Parent = oreModel
    
    local billboard = Instance.new("BillboardGui")
    billboard.Name = "OreBillboard"
    billboard.Adornee = hitbox
    billboard.AlwaysOnTop = true
    billboard.Size = UDim2.new(0, 200, 0, 28)
    billboard.Parent = BillboardGuiContainer
    
    local label = Instance.new("TextLabel")
    label.Name = "OreLabel"
    label.Size = UDim2.new(1, 0, 1, 0)
    label.BackgroundTransparency = 1
    label.Font = Enum.Font.GothamBold
    label.TextScaled = true
    label.TextColor3 = color
    label.TextStrokeTransparency = 0.5
    label.TextStrokeColor3 = Color3.new(0, 0, 0)
    label.Parent = billboard

    ESP_ByHitbox[hitbox] = { 
        highlight = highlight, 
        billboard = billboard, 
        label = label, 
        oreName = oreName, 
        hitbox = hitbox,
        model = oreModel
    }
end

local function RemoveESP(hitbox)
    local data = ESP_ByHitbox[hitbox]
    if not data then return end
    pcall(function()
        if data.highlight and data.highlight.Parent then 
            data.highlight:Destroy() 
        end
        if data.billboard and data.billboard.Parent then 
            data.billboard:Destroy() 
        end
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

-- ===== MONSTER ESP Functions =====
local function CreateMonsterESP(model)
    if not model or not model:IsA("Model") then return end
    if Monster_ByModel[model] then return end
    
    local monsterFullName = model.Name
    local baseMonsterName = MatchMonsterName(monsterFullName)
    
    if not baseMonsterName then return end
    if not MonsterToggle[baseMonsterName] then return end
    
    local color = GetMonsterColor(baseMonsterName)
    local hitbox = GetMonsterHitbox(model)
    
    local highlight = Instance.new("Highlight")
    highlight.Name = "MonsterHighlight"
    highlight.Adornee = model
    highlight.FillColor = color
    highlight.OutlineColor = color
    highlight.FillTransparency = 0.7
    highlight.OutlineTransparency = 0.3
    highlight.DepthMode = Enum.HighlightDepthMode.AlwaysOnTop
    highlight.Parent = model
    
    local billboard = Instance.new("BillboardGui")
    billboard.Name = "MonsterBillboard"
    billboard.Adornee = hitbox
    billboard.AlwaysOnTop = true
    billboard.Size = UDim2.new(0, 200, 0, 28)
    billboard.Parent = MonsterBillboardContainer
    
    local label = Instance.new("TextLabel")
    label.Name = "MonsterLabel"
    label.Size = UDim2.new(1, 0, 1, 0)
    label.BackgroundTransparency = 1
    label.Font = Enum.Font.GothamBold
    label.TextScaled = true
    label.TextColor3 = color
    label.TextStrokeTransparency = 0.5
    label.TextStrokeColor3 = Color3.new(0, 0, 0)
    label.Parent = billboard

    Monster_ByModel[model] = { 
        highlight = highlight, 
        billboard = billboard, 
        label = label, 
        baseMonsterName = baseMonsterName,
        monsterFullName = monsterFullName,
        model = model,
        hitbox = hitbox
    }
end

local function RemoveMonsterESP(model)
    local data = Monster_ByModel[model]
    if not data then return end
    pcall(function()
        if data.highlight and data.highlight.Parent then 
            data.highlight:Destroy() 
        end
        if data.billboard and data.billboard.Parent then 
            data.billboard:Destroy() 
        end
    end)
    Monster_ByModel[model] = nil
end

local function ScanAllMonsters()
    if not MONSTER_FOLDER then 
        -- Jika tidak ada folder Living, cari di seluruh Workspace
        for _, model in ipairs(Workspace:GetDescendants()) do
            if model:IsA("Model") then
                local baseName = MatchMonsterName(model.Name)
                if baseName and MonsterToggle[baseName] then
                    pcall(function() CreateMonsterESP(model) end)
                end
            end
        end
        return
    end
    
    -- Cari monster di dalam folder Living dan subfoldernya
    for _, desc in ipairs(MONSTER_FOLDER:GetDescendants()) do
        if desc:IsA("Model") then
            local baseName = MatchMonsterName(desc.Name)
            if baseName and MonsterToggle[baseName] then
                pcall(function() CreateMonsterESP(desc) end)
            end
        end
    end
end

-- ===== Folder Watching =====
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

local function WatchMonsterFolder(folder)
    if not folder then return end
    folder.DescendantAdded:Connect(function(obj)
        if obj:IsA("Model") then
            local baseName = MatchMonsterName(obj.Name)
            if baseName and MonsterToggle[baseName] then
                pcall(function() CreateMonsterESP(obj) end)
            end
        end
    end)
    folder.DescendantRemoving:Connect(function(obj)
        if obj:IsA("Model") and Monster_ByModel[obj] then
            pcall(function() RemoveMonsterESP(obj) end)
        end
    end)
end

if ROCK_FOLDER then 
    WatchFolder(ROCK_FOLDER) 
end

if MONSTER_FOLDER then
    WatchMonsterFolder(MONSTER_FOLDER)
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
    elseif obj.Name == MONSTER_FOLDER_NAME and obj:IsA("Folder") then
        MONSTER_FOLDER = obj
        for monster, _ in pairs(MonsterToggle) do 
            if MonsterToggle[monster] then 
                ScanAllMonsters() 
            end 
        end
        WatchMonsterFolder(obj)
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
                if data.highlight and data.highlight.Adornee ~= data.model then
                    local newModel = GetActualOreModel(hitbox)
                    data.highlight.Adornee = newModel
                    data.model = newModel
                end
            end
        end
    end
end

local function UpdateMonsterESP()
    local rootPart = player.Character and player.Character:FindFirstChild("HumanoidRootPart")
    for model, data in pairs(Monster_ByModel) do
        if not model or not model.Parent then 
            RemoveMonsterESP(model) 
        else
            local visible = MonsterToggle[data.baseMonsterName]
            if not visible then 
                RemoveMonsterESP(model) 
            else
                local hp = GetMonsterHP(model)
                local dist = rootPart and math.floor((rootPart.Position - data.hitbox.Position).Magnitude) or 0
                if data.label then
                    data.label.Text = string.format("%s | HP: %d | %dm", data.baseMonsterName, hp, dist)
                end
                if data.highlight and data.highlight.Adornee ~= model then
                    data.highlight.Adornee = model
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
    UpdateMonsterESP()
end)

-- ===== GUI SETUP =====
local Window = Rayfield:CreateWindow({
    Name = "DarkCarbon Hub — Ore & Monster ESP",
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

-- ===== ORE ESP TAB =====
local SettingsTab = Window:CreateTab("💎 Ore ESP")

SettingsTab:CreateSection("ESP Settings")

local oreNames = {}
for n, _ in pairs(ORE_DATA) do 
    table.insert(oreNames, n) 
end
table.sort(oreNames)

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

-- ===== MONSTER ESP TAB =====
local MonsterTab = Window:CreateTab("👹 ESP Monster")

MonsterTab:CreateSection("Monster ESP Settings")

-- Informasi sistem matching
MonsterTab:CreateLabel("🔄 Auto-Detect System Active")
MonsterTab:CreateLabel("Matching patterns: Name + Random Numbers")
MonsterTab:CreateLabel("Example: 'Axe Skeleton8444' → 'Axe Skeleton'")

-- Sort monster names
table.sort(MONSTER_BASE_NAMES)

for _, monsterName in ipairs(MONSTER_BASE_NAMES) do
    MonsterTab:CreateToggle({
        Name = monsterName,
        CurrentValue = false,
        Callback = function(val)
            MonsterToggle[monsterName] = val
            if val then
                ScanAllMonsters()
                Rayfield:Notify({
                    Title = "Monster ESP Added",
                    Content = monsterName .. " ESP enabled\nAuto-detect activated",
                    Duration = 2
                })
            else
                for model, data in pairs(Monster_ByModel) do
                    if data.baseMonsterName == monsterName then
                        RemoveMonsterESP(model)
                    end
                end
                Rayfield:Notify({
                    Title = "Monster ESP Removed",
                    Content = monsterName .. " ESP disabled",
                    Duration = 2
                })
            end
        end
    })
end

-- Informasi jika folder monster tidak ditemukan
if not MONSTER_FOLDER then
    MonsterTab:CreateSection("⚠️ Warning")
    MonsterTab:CreateLabel("Folder 'Living' tidak ditemukan di Workspace")
    MonsterTab:CreateLabel("ESP akan mencari monster di seluruh Workspace")
    MonsterTab:CreateLabel("Performance mungkin sedikit menurun")
end

-- Debug button untuk testing matching
MonsterTab:CreateSection("Debug Tools")
MonsterTab:CreateButton({
    Name = "🔄 Rescan All Monsters",
    Callback = function()
        ScanAllMonsters()
        Rayfield:Notify({
            Title = "Rescan Complete",
            Content = "All monsters have been rescanned",
            Duration = 2
        })
    end
})

-- ===== CHARACTER HANDLING =====
player.CharacterAdded:Connect(function(character)
    character:WaitForChild("HumanoidRootPart", 10)
    task.wait(1)
    for oreName, state in pairs(OreToggle) do
        if state then
            ScanOre(oreName)
        end
    end
    for monsterName, state in pairs(MonsterToggle) do
        if state then
            ScanAllMonsters()
        end
    end
end)

-- ===== DEBUG FUNCTIONS =====
local function PrintMonsterMatchExamples()
    print("\n=== Monster Matching Examples ===")
    local testNames = {
        "Axe Skeleton8444",
        "Blazing Slime3389", 
        "Blight Pyromancer7309",
        "Deathaxe Skeleton7902",
        "Bomber8440",
        "Berserker_Vek", -- Should be ignored
        "Player123", -- Should be ignored
        "Zombie1234",
        "Elite Rogue Skeleton9999"
    }
    
    for _, testName in ipairs(testNames) do
        local matched = MatchMonsterName(testName)
        if matched then
            print(string.format("✓ '%s' → '%s'", testName, matched))
        else
            print(string.format("✗ '%s' → No Match (Ignored)", testName))
        end
    end
    print("===============================\n")
end

-- ===== INITIALIZATION =====
-- Clear cache on load
MonsterPatternCache = {}

Rayfield:Notify({
    Title = "DarkCarbon Hub Loaded",
    Content = "Ore & Monster ESP System Ready!\nAuto-detect system active",
    Duration = 3
})

-- Print debug info
print("=====================================")
print("DarkCarbon ESP System Loaded")
print("Total Ore Types: " .. #oreNames)
print("Total Monster Types: " .. #MONSTER_BASE_NAMES)
print("Monster Folder: " .. (MONSTER_FOLDER and "Found (Living)" or "Not Found"))
print("Matching System: Advanced Pattern Matching")
print("=====================================")

-- Run example matching
PrintMonsterMatchExamples()

print("\n✅ System Ready - Monster names will be auto-detected!")
print("Examples that will work:")
print("  - 'Axe Skeleton8444' → 'Axe Skeleton'")
print("  - 'Blazing Slime1234' → 'Blazing Slime'")
print("  - 'Blight Pyromancer5678' → 'Blight Pyromancer'")
print("\n❌ Names that will be ignored:")
print("  - 'Berserker_Vek' (player name)")
print("  - Any name with underscore")
print("=====================================")
