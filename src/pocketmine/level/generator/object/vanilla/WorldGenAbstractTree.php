package net.minecraft.world.gen.feature;

import java.util.Random;
import net.minecraft.block.Block;
import net.minecraft.block.material.Material;
import net.minecraft.init.Blocks;
import net.minecraft.util.math.BlockPos;
import net.minecraft.world.World;

public abstract class WorldGenAbstractTree extends WorldGenerator
{
    public WorldGenAbstractTree(boolean notify)
    {
        super(notify);
    }

    /**
     * returns whether or not a tree can grow into a block
     * For example, a tree will not grow into stone
     *  
     * @param blockType the type of block to be checked
     */
    protected boolean canGrowInto(Block blockType)
    {
        Material material = blockType.getDefaultState().getMaterial();
        return material == Material.air || material == Material.leaves || blockType == Blocks.grass || blockType == Blocks.dirt || blockType == Blocks.log || blockType == Blocks.log2 || blockType == Blocks.sapling || blockType == Blocks.vine;
    }

    public void func_180711_a(World worldIn, Random p_180711_2_, BlockPos p_180711_3_)
    {
    }

    /**
     * sets dirt at a specific location if it isn't already dirt
     */
    protected void setDirtAt(World worldIn, BlockPos pos)
    {
        if (worldIn.getBlockState(pos).getBlock() != Blocks.dirt)
        {
            this.setBlockAndNotifyAdequately(worldIn, pos, Blocks.dirt.getDefaultState());
        }
    }

    public boolean isReplaceable(World world, BlockPos pos)
    {
        net.minecraft.block.state.IBlockState state = world.getBlockState(pos);
        return state.getBlock().isAir(state, world, pos) || state.getBlock().isLeaves(state, world, pos) || state.getBlock().isWood(world, pos) || canGrowInto(state.getBlock());
    }
}