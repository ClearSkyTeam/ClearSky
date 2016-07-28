package net.minecraft.world.gen.feature;

import java.util.Random;
import net.minecraft.block.BlockTorch;
import net.minecraft.init.Blocks;
import net.minecraft.util.EnumFacing;
import net.minecraft.util.math.BlockPos;
import net.minecraft.world.World;

public class WorldGenEndPodium extends WorldGenerator
{
    public static final BlockPos field_186139_a = BlockPos.ORIGIN;
    public static final BlockPos field_186140_b = new BlockPos(field_186139_a.getX() - 4 & -16, 0, field_186139_a.getZ() - 4 & -16);
    private final boolean activePortal;

    public WorldGenEndPodium(boolean activePortalIn)
    {
        this.activePortal = activePortalIn;
    }

    public boolean generate(World worldIn, Random rand, BlockPos position)
    {
        for (BlockPos.MutableBlockPos blockpos$mutableblockpos : BlockPos.getAllInBoxMutable(new BlockPos(position.getX() - 4, position.getY() - 1, position.getZ() - 4), new BlockPos(position.getX() + 4, position.getY() + 32, position.getZ() + 4)))
        {
            double d0 = blockpos$mutableblockpos.getDistance(position.getX(), blockpos$mutableblockpos.getY(), position.getZ());

            if (d0 <= 3.5D)
            {
                if (blockpos$mutableblockpos.getY() < position.getY())
                {
                    if (d0 <= 2.5D)
                    {
                        this.setBlockAndNotifyAdequately(worldIn, blockpos$mutableblockpos, Blocks.bedrock.getDefaultState());
                    }
                    else if (blockpos$mutableblockpos.getY() < position.getY())
                    {
                        this.setBlockAndNotifyAdequately(worldIn, blockpos$mutableblockpos, Blocks.end_stone.getDefaultState());
                    }
                }
                else if (blockpos$mutableblockpos.getY() > position.getY())
                {
                    this.setBlockAndNotifyAdequately(worldIn, blockpos$mutableblockpos, Blocks.air.getDefaultState());
                }
                else if (d0 > 2.5D)
                {
                    this.setBlockAndNotifyAdequately(worldIn, blockpos$mutableblockpos, Blocks.bedrock.getDefaultState());
                }
                else if (this.activePortal)
                {
                    this.setBlockAndNotifyAdequately(worldIn, new BlockPos(blockpos$mutableblockpos), Blocks.end_portal.getDefaultState());
                }
                else
                {
                    this.setBlockAndNotifyAdequately(worldIn, new BlockPos(blockpos$mutableblockpos), Blocks.air.getDefaultState());
                }
            }
        }

        for (int i = 0; i < 4; ++i)
        {
            this.setBlockAndNotifyAdequately(worldIn, position.up(i), Blocks.bedrock.getDefaultState());
        }

        BlockPos blockpos = position.up(2);

        for (EnumFacing enumfacing : EnumFacing.Plane.HORIZONTAL)
        {
            this.setBlockAndNotifyAdequately(worldIn, blockpos.offset(enumfacing), Blocks.torch.getDefaultState().withProperty(BlockTorch.FACING, enumfacing));
        }

        return true;
    }
}