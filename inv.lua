-- Script: NameTag Preventer
-- Tempatkan di StarterPlayerScripts sebagai LocalScript

local Players = game:GetService("Players")
local RunService = game:GetService("RunService")

local player = Players.LocalPlayer

-- Fungsi untuk terus memantau dan menghilangkan nametag
local function monitorAndRemoveNameTags()
    RunService.Heartbeat:Connect(function()
        if player.Character then
            -- Cari dan nonaktifkan BillboardGu
            for _, descendant in ipairs(player.Character:GetDescendants()) do
                if descendant:IsA("BillboardGui") then
                    -- Jika sistem invisibility aktif, pastikan nametag tetap mati
                    if player.Character:GetAttribute("IsInvisible") then
                        descendant.Enabled = false
                        descendant.StudsOffset = Vector3.new(0, -100, 0)
                    end
                end
            end
            
            -- Cari TextLabel di SurfaceGui (custom nameplates)
            for _, surfaceGui in ipairs(player.Character:GetDescendants()) do
                if surfaceGui:IsA("SurfaceGui") then
                    for _, child in ipairs(surfaceGui:GetChildren()) do
                        if (child:IsA("TextLabel") or child:IsA("TextButton")) and 
                           (string.find(child.Text, player.Name) or child.Name == "PlayerName") then
                            if player.Character:GetAttribute("IsInvisible") then
                                child.Visible = false
                            else
                                child.Visible = true
                            end
                        end
                    end
                end
            end
        end
    end)
end

-- Start monitoring ketika karakter ada
local function onCharacterAdded(character)
    monitorAndRemoveNameTags()
end

player.CharacterAdded:Connect(onCharacterAdded)
if player.Character then
    onCharacterAdded(player.Character)
end

print("👁️ NameTag Monitor aktif!")
