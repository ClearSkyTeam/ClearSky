package net.minecraft.world.gen.feature;

import java.util.Random;
import net.minecraft.init.Blocks;
import net.minecraft.util.math.BlockPos;
import net.minecraft.util.math.MathHelper;
import net.minecraft.world.World;

public class WorldGenEndIsland extends WorldGenerator
{
    public boolean generate(World worldIn, Random rand, BlockPos position)
    {
        int i = rand.nextInt(3) + 4;
        float f = (float)i;

        for (int j = 0; f > 0.5F; --j)
        {
            for (int k = MathHelper.floor_float(-f); k <= MathHelper.ceiling_float_int(f); ++k)
            {
                for (int l = MathHelper.floor_float(-f); l <= MathHelper.ceiling_float_int(f); ++l)
                {
                    if ((float)(k * k + l * l) <= (f + 1.0F) * (f + 1.0F))
                    {
                        this.setBlockAndNotifyAdequately(worldIn, position.add(k, j, l), Blocks.end_stone.getDefaultState());
                    }
                }
            }

            f = (float)((double)f - ((double)rand.nextInt(2) + 0.5D));
        }

        return true;
    }
}