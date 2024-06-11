<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LineTemplate;
use App\Models\Wall;
use Exception;
use PhpParser\node\Expr\Cast\Object_;

class WallController extends Controller
{
    function recalculate($wall_id)
    {
        /*  $lineTemplate = LineTemplate::find($project_id);
        $json = json_decode($lineTemplate->local_db);

        $json->wall_length = 721.72;
 */
        $json1 = Wall::find($wall_id);


        $result = $this->processWallCalculations($json1);

        // print("<pre>" . print_r($result, true) . "</pre>");

        return $result;
    }

    function processWallCalculations($data)
    {

        $this->calculaWallMaterial($data);
        $this->calculaBloque1($data);
        $this->calculaBloque2($data);
        $this->calculaBandMaterial($data);
        $this->calculaBloque4($data);
        $this->calculaBloque5($data);
        $this->handleUseCourse($data);
        $this->handleChangeAdditionalDatas($data);


        return  $data;
    }

    #region calcula material   




    public function calculaWallMaterial(&$updatedFormData)
    {
        // echo "calculaWallMaterial<br>";
        // Ensure $updatedFormData is an stdClass object
        if (is_array($updatedFormData)) {
            $updatedFormData = (object)$updatedFormData;
        }

        // Handle changes for main material
        $wall_material = $updatedFormData->wall_material;
        $selectedMaterial = json_decode($wall_material); // Parse the selected material

        // Access the height, width, and length properties of the selected material object
        $materialLength = $selectedMaterial->length;
        $materialHeight = $selectedMaterial->height;
        $materialWidth = $selectedMaterial->width;

        // Calculate units
        $calculateUnit = $this->calculateWallUnit($materialHeight, $materialLength);
        $calculateSqUnit = $this->calculateWallSqUnit($calculateUnit);
        $calculateCubicUnit = $this->calculateWallCubicUnit($materialLength, $materialHeight, $materialWidth);

        // Update the form data
        $updatedFormData->material_height = $materialHeight;
        $updatedFormData->material_width = $materialWidth;
        $updatedFormData->material_length = $materialLength;
        $updatedFormData->wall_material_unit = $calculateUnit;
        $updatedFormData->wall_material_square_unit = $calculateSqUnit;
        $updatedFormData->wall_material_cubic_unit = $calculateCubicUnit;

        return $updatedFormData;
    }

    #endregion calcula material


    public function calculaBloque1(&$updatedFormData)
    {
        // echo "calcula bloque 1<br>";

        $calculatedEffectiveFoundationHeight = $this->calculateFoundationHeight($updatedFormData);
        $calculatedTotalWallHeight = $this->calculatedWallHeight($updatedFormData, $calculatedEffectiveFoundationHeight);
        $calculateTotalWallLength = $this->calculationWallLength($updatedFormData);
        $calculateTotalSquareArea = $this->calculationSquareArea($calculatedTotalWallHeight, $calculateTotalWallLength);
        $calculateTotalCubicArea = $this->calculationCubicArea($updatedFormData, $calculateTotalSquareArea);
        $calculateWallSquareUnits = $this->calculationWallSquareUnit($updatedFormData, $calculateTotalSquareArea);
        // $calculateWallCubicUnits = $this->calculationWallCubicUnit($updatedFormData, $calculateTotalCubicArea);
        $calculateCopingTotals = $this->calculationCopingTotal($updatedFormData);
        $calculateCopingTotalUnits = $this->calculationCopingTotalUnit($updatedFormData, $calculateCopingTotals);
        $calculateTotalAnchor = $this->calculationTotalAnchors($updatedFormData);
        $calculateTotalAnchorCopings = $this->calculationTotalAnchorCoping($updatedFormData);
        $calculateTotalAnchorCopingUnits = $this->calculationTotalAnchorCopingUnits($updatedFormData, $calculateTotalAnchorCopings);

        $updatedFormData->effective_foundation_height = $calculatedEffectiveFoundationHeight;
        $updatedFormData->total_wall_height = $calculatedTotalWallHeight;
        $updatedFormData->total_wall_length = $calculateTotalWallLength;
        $updatedFormData->total_square_area = $calculateTotalSquareArea;
        $updatedFormData->total_cubic_area = $calculateTotalCubicArea;
        $updatedFormData->wall_square_units = $calculateWallSquareUnits;
        // $updatedFormData->wall_cubic_units = $calculateWallCubicUnits;
        // Wall coping material
        $updatedFormData->coping_material_total = $calculateCopingTotals;
        $updatedFormData->coping_material_total_units = $calculateCopingTotalUnits;
        $updatedFormData->anchor_total = $calculateTotalAnchor;
        $updatedFormData->total_anchor_coping = $calculateTotalAnchorCopings;
        $updatedFormData->total_anchor_coping_units = $calculateTotalAnchorCopingUnits;

        return $updatedFormData;
    }


    public function calculaBloque5(&$updatedFormData)
    {
        // echo "calculaBloque5<br>";
        // Calculate functions
        $calculateSpacesFilled = $this->calculateTotalSpacesFilled($updatedFormData);
        $calculateTotalLift = $this->calculateTotalLifts($updatedFormData);
        $calculateRebarLf = $this->calculateRebarLfs($updatedFormData, $calculateTotalLift);
        $calculateVericalRebarTotal = $this->calculateVericalRebarTotals($updatedFormData, $calculateSpacesFilled, $calculateRebarLf);
        $calculateRebarTon = $this->calculateRebarTons($updatedFormData, $calculateVericalRebarTotal);
        $calculatePostionPerTotal = $this->calculatePostionPerTotals($updatedFormData);
        $calculatePostionOtherTotal = $this->calculatePostionOtherTotals($calculateSpacesFilled, $calculatePostionPerTotal);
        $calculateAreaGrouted = $this->calculateAreaGrouteds($updatedFormData, $calculateSpacesFilled);
        $calculateRemainingArea = $this->calculateRemainingAreas($updatedFormData, $calculateAreaGrouted);
        $calculateGroutMaterial = $this->calculateGroutMaterials($updatedFormData, $calculateAreaGrouted);
        $calculateRemainingMaterial = $this->calculateRemainingMaterials($updatedFormData, $calculateRemainingArea);
        //Update Data
        $updatedFormData->total_spaces_filled = $calculateSpacesFilled;
        $updatedFormData->total_lifts = $calculateTotalLift;
        $updatedFormData->rebar_lf_pr_space = $calculateRebarLf;
        $updatedFormData->vertical_rebar_total = $calculateVericalRebarTotal;
        $updatedFormData->vertical_total_rebar_tons = $calculateRebarTon;
        $updatedFormData->vertical_postioner_per_total = $calculatePostionPerTotal;
        $updatedFormData->vertical_postioner_other_total = $calculatePostionOtherTotal;
        $updatedFormData->vertical_grouted_area = $calculateAreaGrouted;
        $updatedFormData->remaining_area = $calculateRemainingArea;
        $updatedFormData->total_grout_mat = $calculateGroutMaterial;
        $updatedFormData->total_remaining_mat = $calculateRemainingMaterial;

        return $updatedFormData;
    }

    public function calculaBloque4(&$updatedFormData)
    {
        // echo "calculaBloque4<br>";
        $half_block_material = $updatedFormData->half_block_material;
        $selectedMaterial = json_decode($half_block_material);
        if ($selectedMaterial != null) {
            $materialLength = $selectedMaterial->length;
            $materialHeight = $selectedMaterial->height;

            $calculateUnit = $this->calculateHalfBlockUnit($materialHeight, $materialLength);
            $calculateSqUnit = $this->calculateHalfBlockSqUnit($calculateUnit);

            $calculateTotalCjSpace = $this->calculateTotalCjSpaces($updatedFormData);
            $calculateTotalCjMaterial = $this->calculateTotalCjMaterials($updatedFormData, $calculateTotalCjSpace);
            $calculateTotalCaulkingMaterial = $this->calculateTotalCaulkingMaterials($updatedFormData, $calculateTotalCjMaterial);
            $calculateTotalCjMaterial_ea = $this->calculateTotalCjMaterials_ea($updatedFormData, $calculateTotalCjSpace);
            $calculateTotalCaulkingMaterial_ea = $this->calculateTotalCaulkingMaterials_ea($updatedFormData, $calculateTotalCjMaterial);
            $calculateTotalHalfBlock = $this->calculateTotalHalfBlocks($updatedFormData, $calculateTotalCjMaterial, $materialLength);
            $calculateTotalHalfUnit = $this->calculateTotalHalfUnits($updatedFormData, $calculateTotalHalfBlock, $calculateUnit);

            if (!is_nan($calculateUnit)) {
                $updatedFormData->half_block_lf_unit = $calculateUnit;
            }
            if (!is_nan($calculateSqUnit)) {
                $updatedFormData->half_block_sq_unit = $calculateSqUnit;
            }
            if (!is_nan($materialLength)) {
                $updatedFormData->half_block_length = $materialLength;
            }

            $updatedFormData->control_total_cj_spaces = $calculateTotalCjSpace;

            $updatedFormData->control_total_cj_material = $calculateTotalCjMaterial;
            $updatedFormData->control_total_caulking_material = $calculateTotalCaulkingMaterial;

            $updatedFormData->control_total_cj_material_ea = $calculateTotalCjMaterial_ea;
            $updatedFormData->control_total_caulking_material_ea = $calculateTotalCaulkingMaterial_ea;

            $updatedFormData->control_total_sq_ft = $calculateTotalHalfBlock;
            $updatedFormData->total_half_unit = $calculateTotalHalfUnit;
        }


        return $updatedFormData;
    }

    public function calculaBandMaterial(&$updatedFormData)
    {
        // echo "calculaBandMaterial<br>";
        return $updatedFormData;
    }

    public function calculaBloque2(&$updatedFormData)
    {
        // echo "calculaBloque2<br>";
        $coping_material = $updatedFormData->coping_material;
        $selectedMaterial = json_decode($coping_material);
        if ($selectedMaterial != null) {
            $materialLength = $selectedMaterial->length;
            $materialHeight = $selectedMaterial->height;
            $materialWidth = $selectedMaterial->width;
            $calculateUnit = $this->calculateCopingUnit($materialHeight, $materialLength);

            $updatedFormData->coping_material_height = $materialHeight;
            $updatedFormData->coping_material_width = $materialWidth;
            $updatedFormData->coping_material_length = $materialLength;

            $updatedFormData->coping_material_unit = $calculateUnit;
        }

        return $updatedFormData;
    }




    public function calculateWallUnit($height, $length)
    {
        // echo "calculateWallUnit<br>";
        return round(($height * $length) / 144, 3);
    }

    public function calculateWallSqUnit($wallUnit)
    {
        // echo "calculateWallSqUnit<br>";
        return round(1 / $wallUnit, 3);
    }

    public function calculateWallCubicUnit($length, $height, $width)
    {
        // echo "calculateWallCubicUnit<br>";
        $wallCubicArea = $length * $height * $width;
        return round(1 / ($wallCubicArea * 1728), 3);
    }




    public function calculateCopingUnit($height, $length)
    {
        // echo "calculateCopingUnit<br>";
        return round(($height * $length) / 144, 3);
    }

    public function calculateRebarUnit($height, $length)
    {
        // echo "calculateRebarUnit<br>";
        return round(($height * $length) / 144, 3);
    }

    public function calculateRebarSqUnit($rebarUnit)
    {
        // echo "calculateRebarSqUnit<br>";
        return round(1 / $rebarUnit, 3);
    }

    public function calculateHalfBlockUnit($height, $length)
    {
        // echo "calculateHalfBlockUnit<br>";
        return round(($height * $length) / 144, 3);
    }

    public function calculateHalfBlockSqUnit($halfBlockUnit)
    {
        // echo "calculateHalfBlockSqUnit<br>";
        return round(1 / $halfBlockUnit, 3);
    }

    public function calculateFoundationHeight($data)
    {
        // echo "calculateFoundationHeight<br>";
        return abs($data->finish_floor - $data->top_of_footing);
    }

    public function calculatedWallHeight($data, $effectiveFoundation)
    {
        // echo "calculatedWallHeight<br>";
        return $effectiveFoundation + $data->wall_height;
    }

    public function calculationWallLength($data)
    {
        // echo "calculationWallLength<br>";
        $riseDrop = ($data->rise_drop === "rise") ? $data->rise_value : $data->drop_value;
        return $data->wall_length + $riseDrop;
    }

    public function calculationSquareArea($totalWallHeight, $totalWallLength)
    {
        // echo "calculationSquareArea<br>";
        return $totalWallHeight * $totalWallLength;
    }

    public function calculationCubicArea($data, $totalSqArea)
    {
        // echo "calculationCubicArea<br>";
        return $data->wall_structure_thickness * $totalSqArea;
    }

    public function calculationWallSquareUnit($data, $totalSqArea)
    {
        // echo "calculationWallSquareUnit<br>";
        return round($data->wall_material_square_unit * $totalSqArea, 3);
    }

    public function calculationCopingTotal($data)
    {
        // echo "calculationCopingTotal<br>";
        return round($data->wall_length * $data->coping_material_quantity, 2);
    }

    public function calculationCopingTotalUnit($data, $total)
    {
        // echo "calculationCopingTotalUnit<br>";
        if ($data->coping_material_length > 0) {
            return round($total / ($data->coping_material_length / 12), 2);
        }
        return 0;
    }

    public function calculationTotalAnchors($data)
    {
        // echo "calculationTotalAnchors<br>";
        if ($data->anchor_spacing > 0 && $data->anchor_quantity > 0) {
            return round($data->wall_length / $data->anchor_spacing * $data->anchor_quantity, 2);
        }
        return 0;
    }

    public function calculationTotalAnchorCoping($data)
    {
        // echo "calculationTotalAnchorCoping<br>";
        if ($data->coping_material_length > 0)
            return round($data->wall_length / ($data->coping_material_length / 12), 2);

        return 0;
    }

    public function calculationTotalAnchorCopingUnits($data, $total)
    {
        // echo "calculationTotalAnchorCopingUnits<br>";
        return round($data->coping_wall_side * $total, 2);
    }

    public function calculateTotalSpacesFilled($data)
    {
        // echo "calculateTotalSpacesFilled<br>";
        if ($data->rebar_spacing > 0 && $data->additional_spacing > 0) {
            return $data->wall_length / $data->rebar_spacing + $data->additional_spacing;
        }
        return 0;
    }

    public function calculateTotalLifts($data)
    {
        // echo "calculateTotalLifts<br>";
        if ($data->rebar_lift_spaces > 0)
            return round($data->total_wall_height / $data->rebar_lift_spaces, 3);

        return 0;
    }

    public function calculateRebarLfs($data, $totalLifts)
    {
        // echo "calculateRebarLfs<br>";
        return round(($data->rebar_lift_spaces + $data->vertical_rebar_overlap) * $totalLifts, 3);
    }

    public function calculateVericalRebarTotals($data, $spacesFilled, $totalRebar)
    {
        // echo "calculateVericalRebarTotals<br>";
        return round($spacesFilled * $totalRebar * $data->bars_per_space, 3);
    }

    public function calculateRebarTons($data, $totalRebarLfts)
    {

        try {
            return round($totalRebarLfts / $data->lft_rebar_per_ton, 3);
        } catch (\Throwable  $ex) {
            // echo "totalRebarLfts " . $totalRebarLfts . "<br>";
            // echo "data->lft_rebar_per_ton " . $data->lft_rebar_per_ton . "<br>";
        }

        // echo "calculateRebarTons<br>";
        return 0;
    }

    public function calculatePostionPerTotals($data)
    {
        try {
            //code...
            return round($data->total_wall_height / $data->vertical_rebar_positioner, 3);
        } catch (\Throwable $th) {
            //throw $th;
            return 0;
        }
    }

    public function calculatePostionOtherTotals($spacesFilled, $positionPerTotal)
    {
        // echo "calculatePostionOtherTotals<br>";
        return round($spacesFilled * $positionPerTotal, 3);
    }

    public function calculateAreaGrouteds($data, $spacesFilled)
    {
        // echo "calculateAreaGrouteds<br>";
        return round($spacesFilled * $data->total_wall_height * 0.66, 3);
    }

    public function calculateRemainingAreas($data, $areaGrouted)
    {
        // echo "calculateRemainingAreas<br>";
        $total_sq_ft_filled_grouted = 0;
        foreach ($data->courses as $course) {
            $course =  (object) $course;

            $total_sq_ft_filled_grouted += $course->sq_ft_filled_grouted;
        }
        return round($data->total_square_area - $data->vertical_grouted_area - $total_sq_ft_filled_grouted, 2);
    }

    public function calculateGroutMaterials($data, $areaGrouted)
    {
        // echo "calculateGroutMaterials<br>";

        try {
            return round($areaGrouted / $data->sq_fill_mat_per_cy, 3);
        } catch (\Throwable $th) {
            //throw $th;
            return 0;
        }
    }

    public function calculateRemainingMaterials($data, $remainingArea)
    {
        // echo "calculateRemainingMaterials<br>";

        try {
            return round($remainingArea / $data->sq_fill_mat_per_cy, 3);
        } catch (\Throwable $th) {
            //throw $th;
            return 0;
        }
    }

    public function calculateTotalCjSpaces($data)
    {
        // echo "calculateTotalCjSpaces<br>";
        try {
            return round($data->wall_length / $data->control_spacing, 3);
        } catch (\Throwable $th) {
            //throw $th;
            return 0;
        }
    }

    public function calculateTotalCjMaterials($data, $totalCjSpaces)
    {
        // echo "calculateTotalCjMaterials<br>";
        return round($data->total_wall_height * $totalCjSpaces, 2);
    }

    public function calculateTotalCaulkingMaterials($data, $totalCjMaterials)
    {
        // echo "calculateTotalCaulkingMaterials<br>";
        return round($data->control_rod_side * $totalCjMaterials, 2);
    }

    public function calculateTotalCjMaterials_ea($data, $totalCjSpaces)
    {
        // echo "calculateTotalCjMaterials_ea<br>";
        $selectedMaterial = json_decode($data->control_material);
        $control_material_length = $selectedMaterial->length / 12;
        try {

            return round($data->control_total_cj_material / $control_material_length, 2);
        } catch (\Throwable $th) {
            //throw $th;
            return 0;
        }
    }

    public function calculateTotalCaulkingMaterials_ea($data, $totalCjMaterials)
    {
        // echo "calculateTotalCaulkingMaterials_ea<br>";
        $selectedMaterial = json_decode($data->control_material);
        $control_material_length = $selectedMaterial->length / 12;
        try {

            return round(($data->control_total_cj_material * $data->control_rod_side) / $control_material_length, 2);
        } catch (\Throwable $th) {
            //throw $th;
            return 0;
        }
    }

    public function calculateTotalHalfBlocks($data, $totalCjMaterials, $materialLength = null)
    {
        // echo "calculateTotalHalfBlocks<br>";
        $halfLength = isset($materialLength) ? $materialLength : $data->half_block_length;

        try {
            return round($totalCjMaterials * ($halfLength / 12 / 2), 2);
        } catch (\Throwable $th) {
            //throw $th;
            return 0;
        }
    }

    public function calculateTotalHalfUnits($data, $halfBlock, $materialUnit = null)
    {
        // echo "calculateTotalHalfUnits<br>";
        $halfUnit = isset($materialUnit) ? $materialUnit : $data->half_block_lf_unit;

        try {

            return round($halfBlock * (1 / ($halfUnit / 2)), 2);
        } catch (\Throwable $th) {
            //throw $th;
            return 0;
        }
    }






    #region Courses

    public function handleUseCourse(&$formData)
    {
        // echo "handleUseCourse<br>";
        // Check if the course is already in the courses array

        $courses = $formData->courses;


        foreach ($courses as $selectedCourseData) {

            $selectedCourseData = (object)$selectedCourseData;
            // echo "selectedCourseData->name" . $selectedCourseData->name . "<br>";
            $calculateTotalMaterialUnit = $this->calculateTotalMaterialUnits($formData, $selectedCourseData);
            $calculateTotalRebar = $this->calculateTotalRebars($formData, $selectedCourseData);
            $calculateRebarCourse = $this->calculateRebarCourses($formData, $selectedCourseData);
            $calculateBandTotalRebarLf = $this->calculateBandTotalRebarLfs($selectedCourseData, $calculateRebarCourse, $calculateTotalRebar);
            $calculateGroutedSq = $this->calculateGroutedSqs($formData, $selectedCourseData);
            $calculateGroutedCy = $this->calculateGroutedCys($selectedCourseData, $calculateGroutedSq);
            $calculateTotalGroutedCy = $this->calculateTotalGroutedCys($selectedCourseData, $calculateGroutedCy);

            $selectedCourseData->total_material_unit = $calculateTotalMaterialUnit;
            $selectedCourseData->total_rebar_length = $calculateTotalRebar;
            $selectedCourseData->total_course = $calculateRebarCourse;
            $selectedCourseData->total_rebar_lf = $calculateBandTotalRebarLf;
            $selectedCourseData->area_grouted_sq = $calculateGroutedSq;
            $selectedCourseData->total_grout_cy = $calculateGroutedCy;
            $selectedCourseData->total_area_grout_sq = $calculateTotalGroutedCy;

            $courses[] = $selectedCourseData;
        }
        $formData->courses = $courses;


        return $formData;
    }
    public function calculateTotalMaterialUnits($data, $course)
    {
        // echo "calculateTotalMaterialUnits<br>";
        $wallLength = floatval($data->wall_length);
        $wallMaterialUnit = floatval($data->wall_material_unit);
        $bandHeight = floatval($course->band_height);
        $materialUnits = round(($wallLength * $bandHeight) / $wallMaterialUnit, 3);
        return $materialUnits;
    }

    public function calculateTotalRebars($data, $course)
    {
        // echo "calculateTotalRebars<br>";
        $wallLength = floatval($data->wall_length);
        $wallMaterialLength = floatval($data->material_length);
        $totalPerEach = floatval($course->total_per_each);
        $totalRebars = round($wallLength / ($wallMaterialLength * $totalPerEach), 3);

        // echo "calculate Total Rebars<br>";
        // echo "wallLength: $wallLength<br>";
        // echo "wallMaterialLength: $wallMaterialLength<br>";
        // echo "totalPerEach: $totalPerEach<br>";

        return $totalRebars;
    }

    public function calculateRebarCourses($data, $course)
    {
        // echo "calculateRebarCourses<br>";
        $bandHeight = floatval($course->band_height);
        $wallMaterialHeight = floatval($data->material_height);
        $totalCourse = round($bandHeight / ($wallMaterialHeight / 12), 3);
        return $totalCourse;
    }

    public function calculateBandTotalRebarLfs($course, $rebarCourse, $totalRebarLength)
    {
        // echo "calculateBandTotalRebarLfs<br>";
        $rebarQuantity = floatval($course->rebar_quantity);
        $totalRebarLf = round($totalRebarLength * $rebarQuantity * $rebarCourse, 3);
        return $totalRebarLf;
    }

    public function calculateGroutedSqs($data, $course)
    {
        // echo "calculateGroutedSqs<br>";
        $wallLength = floatval($data->wall_length);
        $bandHeight = floatval($course->band_height);
        $groutedSq = round($wallLength * $bandHeight, 3);
        return $groutedSq;
    }

    public function calculateGroutedCys($course, $groutedSq)
    {
        // echo "calculateGroutedCys<br>";
        // echo "course" . $course->sq_grouted_per_cy . "<br>";
        // echo "groutedSq" . $groutedSq . "<br>";

        $groutedPrCy = floatval($course->sq_grouted_per_cy);
        $groutedCy = round($groutedPrCy * $groutedSq, 3);
        return $groutedCy;
    }

    public function calculateTotalGroutedCys($course, $groutedCy)
    {
        // echo "calculateTotalGroutedCys<br>";
        $totalGroutedCy = $groutedCy;
        return $totalGroutedCy;
    }

    #endregion region courses


    #region additional datas

    public function handleChangeAdditionalDatas(&$updatedFormData)
    {
        // echo "handleChange<br>";
        /*  $name = $event->name;
        $value = $event->value;
        preg_match('/\[(\d+)\]/', $name, $matches);
        $index = $matches ? (int) $matches[1] : 0;
        $indexedName = preg_replace('/\[\d+\]/', '', $name); */

        $additionalDatas = (object)$updatedFormData->additionalDatas;

        $additionalDatasFinal = [];

        foreach ($additionalDatas as $index  =>  $additionalData) {

            $additionalData = (object)$additionalData;
            // $additionalDatas->additionalDatas[$index]=$additionalData;
            // echo "index " . $index . "<br>";
            // echo "additionalData " . json_encode($additionalData) . "<br>";



            $additional_material = $additionalData->additional_material;
            $selectedMaterial = json_decode($additional_material);
            if ($selectedMaterial != null) {


                $materialLength = $selectedMaterial->length;
                $materialHeight = $selectedMaterial->height;
                $additionalData->additional_material_length = $materialLength;


                $calculateLinealUnit = $this->calculateLinealUnits($index, $updatedFormData, $additionalData);
                $calculateLinealTotalOverlap = $this->calculateLinealTotalOverlaps($index, $updatedFormData, $additionalData);
                $calculateTotalLinealFt = $this->calculateTotalLinealFts($index, $updatedFormData, $calculateLinealUnit, $calculateLinealTotalOverlap);
                $calculateTotalLinealUnit = $this->calculateTotalLinealUnits($index, $updatedFormData, $calculateTotalLinealFt, $additionalData);

                $additionalData->lineal_units = $calculateLinealUnit;
                $additionalData->lineal_total_overlap = $calculateLinealTotalOverlap;
                $additionalData->lineal_total = $calculateTotalLinealFt;
                $additionalData->lineal_total_units = $calculateTotalLinealUnit;



                $selectedMaterial = json_decode($additional_material);
                $materialLength = $selectedMaterial->length;
                $materialHeight = $selectedMaterial->height;
                $additionalData->additional_material_length = $materialLength;


                $calculateSpacingTotal = $this->calculateSpacingTotals($index, $updatedFormData, $additionalData);
                $calculateSpacingTotalUnit = $this->calculateSpacingTotalUnits($index, $updatedFormData, $calculateSpacingTotal, $additionalData);

                $additionalData->spacing_total = $calculateSpacingTotal;
                $additionalData->spacing_total_units = $calculateSpacingTotalUnit;




                $calculateTotalUnitSqft = $this->calculateTotalUnitSqfts($additionalData, $updatedFormData->total_square_area);
                $calculateTotalquantity = $this->calculateTotalquantity1($index, $updatedFormData);

                $additionalData->total_unit_per_sq_ft = $calculateTotalUnitSqft;
                $additionalData->total_unit_quantity = $calculateTotalquantity;
               
            }
            $additionalDatasFinal[] = $additionalData;
        }
        $updatedFormData->additionalDatas = $additionalDatasFinal;
        return $updatedFormData;
    }

    public function calculateLinealUnits($index, $data, $additionalDatas)
    {
        // echo "calculateLinealUnits<br>";

        $materialLength = (float) $additionalDatas->additional_material_length;
        $linealQuantity = (float) $additionalDatas->lineal_quantity;
        $wallLength = (float) $data->wall_length;
        $total_units = round($wallLength / ($materialLength / 12), 2);
        return $total_units;
    }

    public function calculateLinealTotalOverlaps($index, $data, $additionalDatas)
    {
        // echo "calculateLinealTotalOverlaps<br>";
        // $additionalDatas=(object)$data->additionalDatas[$index];
        $materialLength = (float) $additionalDatas->additional_material_length;
        $linealOverlap = (float) $additionalDatas->lineal_unit_overlap;
        $totalOverlap = round(($materialLength / 12) + $linealOverlap, 2);
        return $totalOverlap;
    }

    public function calculateTotalLinealFts($index, $data, $totalUnits, $totalOverlap)
    {
        // echo "calculateTotalLinealFts<br>";
        $additionalDatas = (object)$data->additionalDatas[$index];
        $linealQuantity = (float)  $additionalDatas->lineal_quantity;
        $totallinealFt = round($linealQuantity * $totalUnits * $totalOverlap, 2);
        return $totallinealFt;
    }

    public function calculateTotalLinealUnits($index, $data, $totallineal, $additionalDatas)
    {
        // echo "calculateTotalLinealUnits<br>";

        $materialLength = (float)  $additionalDatas->additional_material_length;
        $totalLinealUnit = round($totallineal / ($materialLength / 12), 2);
        return $totalLinealUnit;
    }

    public function calculateSpacingTotals($index, $data, $additionalDatas)
    {
        // echo "calculateSpacingTotals<br>";
        // $additionalDatas=(object)$data->additionalDatas[$index];
        $totalSpacing = 0;
        $wallLength = (float) $data->total_wall_length;
        $space = (float) $additionalDatas->spacing_space;
        if ($space > 0) {
            $totalSpacing = round($wallLength / $space, 2);
        }

        return $totalSpacing;
    }

    public function calculateSpacingTotalUnits($index, $data, $totalSpacing, $additionalDatas)
    {
        // echo "calculateSpacingTotalUnits<br>";

        $wallHeight = (float) $data->total_wall_height;
        $materialLength = (float) $additionalDatas->additional_material_length;
        $totalSpacingUnits = round(($wallHeight * $totalSpacing) / ($materialLength / 12), 2);
        return $totalSpacingUnits;
    }

    public function calculateTotalUnitSqfts(&$additionalDatas, $total_square_area)
    {
        // echo "calculateTotalUnitSqfts<br>";

        $wallArea = (float) $total_square_area;
        $UnitSqft = (float) $additionalDatas->unit_per_sq_ft;
        $total_lineal_sqft = round($wallArea * $UnitSqft, 2);
        $materialLength = (float) $additionalDatas->additional_material_length;
        $materialLength_ft = $materialLength / 12;
        $additionalDatas->total_lineal_per_sq_ft = $total_lineal_sqft;
        $totalUnitSq = $total_lineal_sqft / $materialLength_ft;
        return $totalUnitSq;
    }

    public function calculateTotalquantity1($index, $data)
    {
        // echo "calculateTotalquantity1<br>";
        $additionalDatas = (object)$data->additionalDatas[$index];
        $total_unit_quantity = (float) isset($additionalDatas->quantity) ? $additionalDatas->quantity : 0;
        return $total_unit_quantity;
    }


    #endregion additional datas


}
