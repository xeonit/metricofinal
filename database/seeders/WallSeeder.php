<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Wall;

class WallSeeder extends Seeder
{
    public function run()
    {
        $data = json_decode('{
            "additionalDatas": [
                {
                    "additional_material": " ",
                    "additional_type": "quantity",
                    "lineal_quantity": "2",
                    "lineal_units": "0.20",
                    "lineal_unit_overlap": "2",
                    "lineal_total_overlap": "502.00",
                    "lineal_total": "200.80",
                    "lineal_total_units": "0.40",
                    "spacing_space": "2",
                    "spacing_total": "50.00",
                    "spacing_total_units": "2.00",
                    "unit_per_sq_ft": "0.75",
                    "total_unit_per_sq_ft": 3,
                    "total_lineal_per_sq_ft": "1500.00",
                    "total_unit_quantity": 3,
                    "additional_material_length": 6000,
                    "quantity": "3"
                }
            ],
            "courses": [],
            "name": "",
            "wall_material_value": "1",
            "trade": null,
            "shape": null,
            "gable_value": null,
            "slope_value": null,
            "rise_drop": null,
            "rise_value": "0",
            "drop_value": "0",
            "wall_height": "18",
            "finish_floor": "0",
            "top_of_footing": "-2",
            "effective_foundation_height": 2,
            "total_wall_height": 20,
            "wall_length": "100",
            "total_wall_length": "100",
            "wall_structure_thickness": "0",
            "total_square_area": 2000,
            "total_cubic_area": 0,
            "wall_square_units": "2250.000",
            "wall_cubic_units": null,
            "coping_material": "",
            "coping_material_quantity": "1",
            "coping_material_total": "100.00",
            "coping_material_total_units": "75.00",
            "anchor_material": "",
            "anchor_spacing": "2",
            "anchor_quantity": "2",
            "anchor_total": "100.00",
            "top_wall_material": "",
            "coping_wall_side": "2",
            "total_anchor_coping": "75.00",
            "total_anchor_coping_units": "150.00",
            "bars_per_ton": "0",
            "grout_fill_material": "",
            "rebar_spacing": "2",
            "additional_spacing": "2",
            "total_spaces_filled": 52,
            "rebar_lift_spaces": "4",
            "total_lifts": "5.000",
            "vertical_rebar_overlap": "3",
            "rebar_lf_pr_space": "35.000",
            "bars_per_space": "2",
            "vertical_rebar_total": "3640.000",
            "lft_rebar_per_ton": "1950",
            "vertical_total_rebar_tons": "1.867",
            "vertical_rebar_positioner": "4",
            "vertical_postioner_per_total": "5.000",
            "vertical_postioner_other_total": "260.000",
            "vertical_grout_material": "",
            "vertical_grouted_area": "686.400",
            "remaining_area": "1113.60",
            "vertical_fill_remaining": "",
            "sq_fill_mat_per_cy": "50",
            "total_grout_mat": "13.728",
            "total_remaining_mat": "22.272",
            "control_material": "",
            "control_spacing": "20",
            "control_rod": "",
            "control_rod_side": "2",
            "half_block_material": "",
            "control_total_cj_spaces": "5.000",
            "control_total_cj_material": "100.00",
            "control_total_cj_material_ea": "5.00",
            "control_total_caulking_material": "200.00",
            "control_total_caulking_material_ea": "10.00",
            "control_total_sq_ft": "2.79",
            "total_half_unit": "1860.00",
            "note": null,
            "half_block_lf_unit": "0.003",
            "half_block_sq_unit": "333.333",
            "half_block_length": 0.67,
            "material_height": 8,
            "material_width": 12,
            "material_length": 16,
            "wall_material_unit": "0.889",
            "wall_material_square_unit": "1.125",
            "wall_material_cubic_unit": 3.767602237654321e-7,
            "coping_material_height": 8,
            "coping_material_width": 12,
            "coping_material_length": 16,
            "coping_material_unit": "0.889"
        }', true);

        Wall::create($data);
    }
}