-- ============================================================--
-- DARKCARBON HUB + Ore ESP + Monster ESP - Rayfield Version
-- Tab: Ore ESP dan Monster ESP (Fixed based on reference)
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

-- ===== Monster Data =====
local MONSTER_DATA = {
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
    "Blight Puromancer",
    "Slime",
    "Burning Slime"
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
    ["Blight Puromancer"] = Color3.fromRGB(150, 0, 150),
    ["Slime"] = Color3.fromRGB(0, 150, 255),
    ["Burning Slime"] = Color3.fromRGB(255, 100, 0),
    DEFAULT = Color3.fromRGB(255, 255, 255)
}

local function GetOreColor(n) 
    return ORE_COLORS[n] or ORE_COLORS.DEFAULT 
end

local function GetMonsterColor(n)
    return MONSTER_COLORS[n] or MONSTER_COLORS.DEFAULT
end

-- ===== ESP State =====
-- Ore ESP
local ESP_ByHitbox = {} -- [hitbox] = {highlight, billboard, label, oreName}
local OreToggle = {}    -- per-ore ON/OFF
for k, _ in pairs(ORE_DATA) do 
    OreToggle[k] = false 
end

-- Monster ESP
local MonsterESP_ByModel = {} -- [model] = {highlight, billboard, label, monsterName}
local MonsterToggle = {}      -- per-monster ON/OFF
for _, monsterName in ipairs(MONSTER_DATA) do
    MonsterToggle[monsterName] = false
end

-- Folder rocks
local ROCK_FOLDER_NAME = "Rocks"
local ROCK_FOLDER = Workspace:FindFirstChild(ROCK_FOLDER_NAME)

-- Find the Living folder (CRITICAL for Monster ESP)
local LIVING_FOLDER = workspace:WaitForChild("Living") or workspace:FindFirstChild("Living")

-- Billboard containers
local OreBillboardContainer = Instance.new("ScreenGui")
OreBillboardContainer.Name = "OreESP_Billboards"
OreBillboardContainer.ResetOnSpawn = false
OreBillboardContainer.Parent = PlayerGui

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

local function GetActualOreModel(hitbox)
    local model = hitbox.Parent
    if model and model:IsA("Model") then
        return model
    end
    local parent = model and model.Parent
    if parent and parent:IsA("Model") then
        return parent
    end
    return model or hitbox
end

-- ===== ORE ESP Functions =====
local function CreateOreESP(hitbox)
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
    billboard.Parent = OreBillboardContainer
    
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

local function RemoveOreESP(hitbox)
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
            pcall(function() CreateOreESP(desc) end)
        end
    end
end

-- ===== MONSTER ESP Functions (FIXED based on reference) =====
local function GetClaimantName(monsterModel)
    local status = monsterModel:FindFirstChild("Status")
    if not status then return nil end
    
    local damageDone = status:FindFirstChild("DamageDone")
    if not damageDone or not damageDone.Value then return nil end
    
    local claimant = damageDone.Value
    if claimant:IsA("Player") then
        return claimant.Name
    elseif claimant:IsA("Model") then
        return claimant.Name
    elseif type(claimant) == "string" then
        return claimant
    end
    return nil
end

local function IsMonsterAttacking(monsterModel)
    local status = monsterModel:FindFirstChild("Status")
    if not status then return false end
    
    local attacking = status:FindFirstChild("Attacking")
    if not attacking then return false end
    
    local attackValue = attacking.Value
    if type(attackValue) == "boolean" then 
        return attackValue == true
    elseif type(attackValue) == "number" then 
        return attackValue > 0
    elseif type(attackValue) == "string" then 
        return attackValue:lower() == "true" or attackValue == "1"
    end
    return false
end

local function GetMonsterHP(monsterModel)
    local humanoid = monsterModel:FindFirstChildWhichIsA("Humanoid")
    if humanoid then
        return math.floor(humanoid.Health)
    end
    return 0
end

local function CreateMonsterESP(monsterModel)
    if not monsterModel or not monsterModel:IsA("Model") then return end
    if MonsterESP_ByModel[monsterModel] then return end
    
    local monsterName = monsterModel.Name
    if not MonsterToggle[monsterName] then return end
    local color = GetMonsterColor(monsterName)
    
    -- Find the best part to attach the ESP to
    local rootPart = monsterModel:FindFirstChild("HumanoidRootPart") or 
                     monsterModel.PrimaryPart or 
                     monsterModel:FindFirstChildWhichIsA("BasePart")
    if not rootPart then return end
    
    -- 1. Create HIGHLIGHT
    local highlight = Instance.new("Highlight")
    highlight.Name = "MonsterHighlight"
    highlight.Adornee = monsterModel
    highlight.FillColor = color
    highlight.OutlineColor = color
    highlight.FillTransparency = 0.6
    highlight.OutlineTransparency = 0.2
    highlight.DepthMode = Enum.HighlightDepthMode.AlwaysOnTop
    highlight.Parent = monsterModel
    
    -- 2. Create BILLBOARD for info
    local billboard = Instance.new("BillboardGui")
    billboard.Name = "MonsterBillboard"
    billboard.Adornee = rootPart
    billboard.AlwaysOnTop = true
    billboard.Size = UDim2.new(0, 250, 0, 32)
    billboard.Parent = MonsterBillboardContainer
    
    local label = Instance.new("TextLabel")
    label.Name = "MonsterLabel"
    label.Size = UDim2.new(1, 0, 1, 0)
    label.BackgroundTransparency = 1
    label.Font = Enum.Font.GothamBold
    label.TextScaled = true
    label.TextColor3 = color
    label.TextStrokeTransparency = 0.4
    label.TextStrokeColor3 = Color3.new(0, 0, 0)
    label.Parent = billboard

    -- Get initial info for the label
    local claimant = GetClaimantName(monsterModel)
    local hp = GetMonsterHP(monsterModel)
    local isAttacking = IsMonsterAttacking(monsterModel)
    
    local statusText = ""
    if claimant then
        statusText = claimant == player.Name and "[YOU]" or "[" .. claimant .. "]"
    else
        statusText = "[UNCLAIMED]"
    end
    
    if isAttacking then
        statusText = statusText .. " ⚔️"
    end
    
    MonsterESP_ByModel[monsterModel] = { 
        highlight = highlight, 
        billboard = billboard, 
        label = label, 
        monsterName = monsterName, 
        model = monsterModel,
        rootPart = rootPart,
        claimant = claimant
    }
    
    -- Set the initial text
    if label then
        label.Text = string.format("%s %s | HP: %d", monsterName, statusText, hp)
    end
end

local function RemoveMonsterESP(monsterModel)
    local data = MonsterESP_ByModel[monsterModel]
    if not data then return end
    pcall(function()
        if data.highlight and data.highlight.Parent then 
            data.highlight:Destroy() 
        end
        if data.billboard and data.billboard.Parent then 
            data.billboard:Destroy() 
        end
    end)
    MonsterESP_ByModel[monsterModel] = nil
end

local function ScanMonster(monsterName)
    if not LIVING_FOLDER then 
        warn("[Monster ESP] 'Living' folder not found in workspace.")
        return 
    end
    
    for _, entity in ipairs(LIVING_FOLDER:GetChildren()) do
        if entity:IsA("Model") and entity.Name == monsterName then
            if entity:FindFirstChild("Status") then
                pcall(function() 
                    CreateMonsterESP(entity) 
                end)
            end
        end
    end
end

-- ===== Folder Watchers =====
local function WatchOreFolder(folder)
    if not folder then return end
    folder.DescendantAdded:Connect(function(obj)
        if obj:IsA("BasePart") and obj.Name == "Hitbox" then
            local oreName = obj.Parent and obj.Parent.Name
            if OreToggle[oreName] then 
                pcall(function() CreateOreESP(obj) end) 
            end
        end
    end)
    folder.DescendantRemoving:Connect(function(obj)
        if obj:IsA("BasePart") and ESP_ByHitbox[obj] then
            pcall(function() RemoveOreESP(obj) end)
        end
    end)
end

local function WatchMonsters()
    if not LIVING_FOLDER then return end
    
    -- Monitor for new monsters that appear
    LIVING_FOLDER.ChildAdded:Connect(function(obj)
        if obj:IsA("Model") and MonsterToggle[obj.Name] then
            task.wait(0.1)
            if obj:FindFirstChild("Status") then
                pcall(function() CreateMonsterESP(obj) end)
            end
        end
    end)
    
    LIVING_FOLDER.ChildRemoved:Connect(function(obj)
        if obj:IsA("Model") and MonsterESP_ByModel[obj] then
            pcall(function() RemoveMonsterESP(obj) end)
        end
    end)
end

if ROCK_FOLDER then 
    WatchOreFolder(ROCK_FOLDER) 
end

-- Setup monster watcher
WatchMonsters()

Workspace.DescendantAdded:Connect(function(obj)
    if obj.Name == ROCK_FOLDER_NAME and obj:IsA("Folder") then
        ROCK_FOLDER = obj
        for ore, _ in pairs(OreToggle) do 
            if OreToggle[ore] then 
                ScanOre(ore) 
            end 
        end
        WatchOreFolder(obj)
    end
end)

-- ===== Throttled update =====
local accumulator = 0
local UPDATE_INTERVAL = 0.25
local function UpdateESP()
    local playerRoot = player.Character and player.Character:FindFirstChild("HumanoidRootPart")
    
    -- Update Ore ESP
    for hitbox, data in pairs(ESP_ByHitbox) do
        if not hitbox or not hitbox.Parent then 
            RemoveOreESP(hitbox) 
        else
            local visible = OreToggle[data.oreName]
            if not visible then 
                RemoveOreESP(hitbox) 
            else
                local hp = GetOreHP(hitbox)
                local dist = playerRoot and math.floor((playerRoot.Position - hitbox.Position).Magnitude) or 0
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
    
    -- Update Monster ESP
    for model, data in pairs(MonsterESP_ByModel) do
        if not model or not model.Parent then 
            RemoveMonsterESP(model) 
        else
            local visible = MonsterToggle[data.monsterName]
            if not visible then 
                RemoveMonsterESP(model) 
            else
                local hp = GetMonsterHP(model)
                local dist = playerRoot and data.rootPart and math.floor((playerRoot.Position - data.rootPart.Position).Magnitude) or 0
                local claimant = GetClaimantName(model)
                local isAttacking = IsMonsterAttacking(model)
                
                local statusText = ""
                if claimant then
                    statusText = claimant == player.Name and "[YOU]" or "[" .. claimant .. "]"
                else
                    statusText = "[UNCLAIMED]"
                end
                
                if isAttacking then
                    statusText = statusText .. " ⚔️"
                end
                
                if data.label then
                    data.label.Text = string.format("%s %s | HP: %d | %dm", 
                        data.monsterName, statusText, hp, dist)
                end
                
                -- Update billboard adornee if rootPart changed
                if data.rootPart and data.rootPart.Parent ~= model then
                    local newRoot = model:FindFirstChild("HumanoidRootPart") or 
                                   model.PrimaryPart or 
                                   model:FindFirstChildWhichIsA("BasePart")
                    if newRoot then
                        data.billboard.Adornee = newRoot
                        data.rootPart = newRoot
                    end
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
    Name = "DarkCarbon Hub — ESP System",
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
local OreTab = Window:CreateTab("💎 Ore ESP")

OreTab:CreateSection("Ore ESP Settings")

-- Sort ore names
local oreNames = {}
for n, _ in pairs(ORE_DATA) do 
    table.insert(oreNames, n) 
end
table.sort(oreNames)

-- Create toggle for each ore
for _, oreName in ipairs(oreNames) do
    OreTab:CreateToggle({
        Name = oreName .. " (" .. tostring(ORE_DATA[oreName] or 0) .. " HP)",
        CurrentValue = false,
        Callback = function(val)
            OreToggle[oreName] = val
            if val then
                ScanOre(oreName)
                Rayfield:Notify({
                    Title = "Ore ESP Added",
                    Content = oreName .. " ESP enabled",
                    Duration = 2
                })
            else
                for hitbox, data in pairs(ESP_ByHitbox) do
                    if data.oreName == oreName then 
                        RemoveOreESP(hitbox) 
                    end
                end
                Rayfield:Notify({
                    Title = "Ore ESP Removed",
                    Content = oreName .. " ESP disabled",
                    Duration = 2
                })
            end
        end
    })
end

-- ===== MONSTER ESP TAB =====
local MonsterTab = Window:CreateTab("👹 Monster ESP")

MonsterTab:CreateSection("Monster ESP Settings")

-- Sort monster names
local monsterNamesSorted = {}
for _, monsterName in ipairs(MONSTER_DATA) do
    table.insert(monsterNamesSorted, monsterName)
end
table.sort(monsterNamesSorted)

-- Create toggle for each monster
for _, monsterName in ipairs(monsterNamesSorted) do
    MonsterTab:CreateToggle({
        Name = monsterName,
        CurrentValue = false,
        Callback = function(val)
            MonsterToggle[monsterName] = val
            if val then
                ScanMonster(monsterName)
                Rayfield:Notify({
                    Title = "Monster ESP Added",
                    Content = monsterName .. " ESP enabled",
                    Duration = 2
                })
            else
                for model, data in pairs(MonsterESP_ByModel) do
                    if data.monsterName == monsterName then 
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

-- Info section
MonsterTab:CreateParagraph({
    Title = "ℹ️ ESP Information",
    Content = "Highlights monsters in the 'Living' folder\nDisplays: Name, Claim Status, HP, Distance\n⚔️ = Monster is attacking\n[YOU] = Claimed by you\n[PLAYERNAME] = Claimed by other\n[UNCLAIMED] = Available"
})

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
    -- Rescan all active monsters
    for monsterName, state in pairs(MonsterToggle) do
        if state then
            ScanMonster(monsterName)
        end
    end
end)

-- ===== INITIALIZATION =====
-- Initial notification
Rayfield:Notify({
    Title = "DarkCarbon Hub Loaded",
    Content = "Ore ESP + Monster ESP System Ready!",
    Duration = 4
})

-- Initial scan untuk monsters yang sudah ada di game
task.spawn(function()
    task.wait(2)
    print("[DarkCarbon ESP] Performing initial monster scan...")
    if LIVING_FOLDER then
        print("[DarkCarbon ESP] Found 'Living' folder, scanning...")
        for _, monsterName in ipairs(MONSTER_DATA) do
            if MonsterToggle[monsterName] then
                ScanMonster(monsterName)
            end
        end
    else
        warn("[DarkCarbon ESP] 'Living' folder NOT found!")
    end
end)

print("=====================================")
print("DarkCarbon ESP System Loaded")
print("Total Ore Types: " .. #oreNames)
print("Total Monster Types: " .. #MONSTER_DATA)
print("ESP Type: Highlight (Follows Object Shape)")
print("=====================================")
