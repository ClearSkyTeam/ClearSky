package net.minecraft.world.gen.feature;

import java.util.Random;
import net.minecraft.entity.item.EntityEnderCrystal;
import net.minecraft.init.Blocks;
import net.minecraft.util.math.AxisAlignedBB;
import net.minecraft.util.math.BlockPos;
import net.minecraft.util.math.MathHelper;
import net.minecraft.world.World;

public class WorldGenSpikes extends WorldGenerator
{
    private boolean field_186145_a = false;
    private WorldGenSpikes.EndSpike field_186146_b = null;
    private BlockPos beamTarget;

    public void func_186143_a(WorldGenSpikes.EndSpike p_186143_1_)
    {
        this.field_186146_b = p_186143_1_;
    }

    public void func_186144_a(boolean p_186144_1_)
    {
        this.field_186145_a = p_186144_1_;
    }

    public boolean generate(World worldIn, Random rand, BlockPos position)
    {
        if (this.field_186146_b == null)
        {
            throw new IllegalStateException("Decoration requires priming with a spike");
        }
        else
        {
            int i = this.field_186146_b.func_186148_c();

            for (BlockPos.MutableBlockPos blockpos$mutableblockpos : BlockPos.getAllInBoxMutable(new BlockPos(position.getX() - i, 0, position.getZ() - i), new BlockPos(position.getX() + i, this.field_186146_b.func_186149_d() + 10, position.getZ() + i)))
            {
                if (blockpos$mutableblockpos.distanceSq((double)position.getX(), (double)blockpos$mutableblockpos.getY(), (double)position.getZ()) <= (double)(i * i + 1) && blockpos$mutableblockpos.getY() < this.field_186146_b.func_186149_d())
                {
                    this.setBlockAndNotifyAdequately(worldIn, blockpos$mutableblockpos, Blocks.obsidian.getDefaultState());
                }
                else if (blockpos$mutableblockpos.getY() > 65)
                {
                    this.setBlockAndNotifyAdequately(worldIn, blockpos$mutableblockpos, Blocks.air.getDefaultState());
                }
            }

            if (this.field_186146_b.func_186150_e())
            {
                for (int j = -2; j <= 2; ++j)
                {
                    for (int k = -2; k <= 2; ++k)
                    {
                        if (MathHelper.abs_int(j) == 2 || MathHelper.abs_int(k) == 2)
                        {
                            this.setBlockAndNotifyAdequately(worldIn, new BlockPos(position.getX() + j, this.field_186146_b.func_186149_d(), position.getZ() + k), Blocks.iron_bars.getDefaultState());
                            this.setBlockAndNotifyAdequately(worldIn, new BlockPos(position.getX() + j, this.field_186146_b.func_186149_d() + 1, position.getZ() + k), Blocks.iron_bars.getDefaultState());
                            this.setBlockAndNotifyAdequately(worldIn, new BlockPos(position.getX() + j, this.field_186146_b.func_186149_d() + 2, position.getZ() + k), Blocks.iron_bars.getDefaultState());
                        }

                        this.setBlockAndNotifyAdequately(worldIn, new BlockPos(position.getX() + j, this.field_186146_b.func_186149_d() + 3, position.getZ() + k), Blocks.iron_bars.getDefaultState());
                    }
                }
            }

            EntityEnderCrystal entityendercrystal = new EntityEnderCrystal(worldIn);
            entityendercrystal.setBeamTarget(this.beamTarget);
            entityendercrystal.setEntityInvulnerable(this.field_186145_a);
            entityendercrystal.setLocationAndAngles((double)((float)position.getX() + 0.5F), (double)(this.field_186146_b.func_186149_d() + 1), (double)((float)position.getZ() + 0.5F), rand.nextFloat() * 360.0F, 0.0F);
            worldIn.spawnEntityInWorld(entityendercrystal);
            this.setBlockAndNotifyAdequately(worldIn, new BlockPos(position.getX(), this.field_186146_b.func_186149_d(), position.getZ()), Blocks.bedrock.getDefaultState());
            return true;
        }
    }

    /**
     * Sets the value that will be used in a call to entitycrystal.setBeamTarget.
     * At the moment, WorldGenSpikes.setBeamTarget is only ever called with a value of (0, 128, 0)
     */
    public void setBeamTarget(BlockPos pos)
    {
        this.beamTarget = pos;
    }

    public static class EndSpike
        {
            private final int field_186155_a;
            private final int field_186156_b;
            private final int field_186157_c;
            private final int field_186158_d;
            private final boolean field_186159_e;
            private final AxisAlignedBB field_186160_f;

            public EndSpike(int p_i47020_1_, int p_i47020_2_, int p_i47020_3_, int p_i47020_4_, boolean p_i47020_5_)
            {
                this.field_186155_a = p_i47020_1_;
                this.field_186156_b = p_i47020_2_;
                this.field_186157_c = p_i47020_3_;
                this.field_186158_d = p_i47020_4_;
                this.field_186159_e = p_i47020_5_;
                this.field_186160_f = new AxisAlignedBB((double)(p_i47020_1_ - p_i47020_3_), 0.0D, (double)(p_i47020_2_ - p_i47020_3_), (double)(p_i47020_1_ + p_i47020_3_), 256.0D, (double)(p_i47020_2_ + p_i47020_3_));
            }

            public boolean func_186154_a(BlockPos p_186154_1_)
            {
                int i = this.field_186155_a - this.field_186157_c;
                int j = this.field_186156_b - this.field_186157_c;
                return p_186154_1_.getX() == (i & -16) && p_186154_1_.getZ() == (j & -16);
            }

            public int func_186151_a()
            {
                return this.field_186155_a;
            }

            public int func_186152_b()
            {
                return this.field_186156_b;
            }

            public int func_186148_c()
            {
                return this.field_186157_c;
            }

            public int func_186149_d()
            {
                return this.field_186158_d;
            }

            public boolean func_186150_e()
            {
                return this.field_186159_e;
            }

            public AxisAlignedBB func_186153_f()
            {
                return this.field_186160_f;
            }
        }
}