@extends('admin.layouts.app')

@section('title', 'Materials')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Material</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                    <li class="breadcrumb-item">Material</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-md-12 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="pt-3 new-project">
                                <div class="text-center card-title">
                                    Create Material
                                </div>
                                <form method="post" action="{{ route('admin.material.create') }}">
                                    @csrf()
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label>Division: <span class="text-danger">*</span></label>
                                                <select class="form-control" name="material_division_id"
                                                    id="material_division_id" required>
                                                    <option value="" hidden selected>Choose Division</option>
                                                    @php
                                                        $material_divisions = get_material_divisions();
                                                    @endphp
                                                    @foreach ($material_divisions as $material_division)
                                                        <option value="{{ $material_division->id }}">
                                                            {{ $material_division->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label>Class: <span class="text-danger">*</span></label>
                                                @php
                                                    $material_classes = get_material_classes();
                                                @endphp
                                                <select class="form-control" name="material_class_id" id="material_class_id"
                                                    required>
                                                    <option value="">Choose Class</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label>Name: <span class="text-danger">*</span></label>
                                                <input class="form-control material_name" placeholder="Material 1" name="name"
                                                    required />
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label>Description:</label>
                                                <textarea class="form-control" rows="5" placeholder="Description" name="description"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label>Default Unit Count: <span class="text-danger">*</span></label>
                                                <input class="form-control default_unit" type="text" name="default_unit"
                                                    id="default_unit" list="default_unit-count" placeholder="Unit"
                                                    autocomplete="off" required>
                                                <data-list id="default_unit-count">
                                                    @php
                                                        $default_units = get_default_units();
                                                    @endphp
                                                    @foreach ($default_units as $default_unit)
                                                        <option>{{ $default_unit->unit }}</option>
                                                    @endforeach()
                                                </data-list>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            @php
                                                $units = get_length_units();
                                            @endphp
                                            <input type="hidden" name="measurement_unit" value="{{ $units->symbol }}">
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label>Length ({{ $units->symbol }}):</label>
                                                <input type="hidden" id="length" value="0" name="length">
                                                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                                    <div class="form-control fraction-input" data-target="length"
                                                        tabindex="-1">
                                                        <div class="whole" contenteditable="true">0</div>
                                                        <div class="fraction">
                                                            <div class="sup" contenteditable="true">0</div>
                                                            <hr>
                                                            <div class="sub" contenteditable="true">0</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label>Width ({{ $units->symbol }}):</label>
                                                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                                    <input type="hidden" id="width" value="0" name="width">
                                                    <div class="form-control fraction-input" data-target="width"
                                                        tabindex="-1">
                                                        <div class="whole" contenteditable="true">0</div>
                                                        <div class="fraction">
                                                            <div class="sup" contenteditable="true">0</div>
                                                            <hr>
                                                            <div class="sub" contenteditable="true">0</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label>Height ({{ $units->symbol }}):</label>
                                                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                                    <input type="hidden" id="height" name="height" value="0">
                                                    <div class="form-control fraction-input" data-target="height"
                                                        tabindex="-1">
                                                        <div class="whole" contenteditable="true">0</div>
                                                        <div class="fraction">
                                                            <div class="sup" contenteditable="true">0</div>
                                                            <hr>
                                                            <div class="sub" contenteditable="true">0</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>Price:</label>
                                                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                                    <input type="number" step="0.001"
                                                        class="form-control currency-amount" placeholder="$ / "
                                                        size="8" name="prices" id="prices">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label>Waste(%):</label>
                                                <input type="number" step="0.001" class="form-control"
                                                    placeholder="Waste" name="waste">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>Production Rate:</label>
                                                <div class="form-control production_rate">
                                                    <input type="number" step="0.001" min="0"
                                                        class="optional_field production_field"
                                                        data-option="production_subbed_out" placeholder="Unit"
                                                        name="production_rate">
                                                    <span id="production_unit">Piece</span>&nbsp;
                                                    Per
                                                    <select>
                                                        <option value="day">Day</option>
                                                        <option value="week">Week</option>
                                                        <option value="month">Month</option>
                                                    </select>
                                                    /
                                                    <select name="" id="">
                                                        @php
                                                            $labors = get_master_labors();
                                                        @endphp
                                                        @foreach ($labors as $labor)
                                                            <option value="{{ $labor->id }}">{{ $labor->labor_type }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <h6 class="text-center">OR</h6>
                                        <div class="col-12n">
                                            <div class="form-group">
                                                <label>Subed Out cost:</label>
                                                <input type="number" step="0.001" min="0"
                                                    class="form-control production_subbed_out optional_field"
                                                    data-option="production_field" placeholder="$"
                                                    name="production_subed_out_cost">
                                                <b>Note- this overrides cost associated with production</b>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>Cleaning Cost Inhouse:</label>
                                                <input type="number" step="0.001" min="0"
                                                    class="form-control cleaning_cost optional_field"
                                                    data-option="cleaning_subbed" placeholder="$" name="cleaning_cost">
                                            </div>
                                        </div>
                                        <h6 class="text-center">OR</h6>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>Cleaning Subbed out:</label>
                                                <input type="number" step="0.001" min="0"
                                                    class="form-control optional_field cleaning_subbed"
                                                    data-option="cleaning_cost" placeholder="$"
                                                    name="cleaning_subed_out">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <h3 class="fringe_area text-center">Other Material Associated</h3>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mat_field_container">
                                            <div class="col-3">
                                                <label>Material</label>
                                                <select class="form-control other_material"
                                                    name="associated_products[0][material_id]">
                                                    <option value="">Material</option>
                                                    @php
                                                        $other_materials = get_materials();
                                                    @endphp
                                                    @foreach ($other_materials as $other_material)
                                                        <option value="{{ $other_material->id }}"
                                                            data-unit="{{ $other_material->default_unit }}">
                                                            {{ $other_material->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-1">
                                                <label>Count</label>
                                                <input type="number" class="form-control" name="associated_products[0][required]"
                                                    placeholder="0" >
                                            </div>
                                            <div class="col-1">
                                                <label>Unit</label>
                                                <input class="form-control other_material_unit" name="associated_products[0][unit]"
                                                    placeholder="Unit" readonly>
                                            </div>
                                            
                                            <b>For every</b>
                                            <div class="col-1">
                                                <label>Count</label>
                                                <input type="number" class="form-control" name="associated_products[0][for]"
                                                    placeholder="0" >
                                            </div>
                                            <div class="col-1">
                                                <label>Unit</label>
                                                <input class="form-control default_unit"
                                                    placeholder="Unit" readonly>
                                            </div>
                                            <div class="col-2">
                                                <label>Material</label>
                                                <input class="form-control material_name"
                                                    placeholder="Material Name" readonly>
                                            </div>
                                        </div>
                                        <div class="more-material"></div>
                                        <div class="col-md-3 mt-2">
                                            <button type="button" class="btn btn-sm btn-warning add-more">Add
                                                More</button>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group text-center">
                                                <a href="#" onclick="history.back()"
                                                    class="btn btn-warning">Back</a>
                                                <button class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!--end card-body-->
                    </div>
                </div>
            </div>
        </section>

    </main>


@endsection()

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        let oldValue = ''
        let MaterialName = '';
        let DefaultUnit = '';
        const updateDefaultUnit = (unit) => {
            DefaultUnit = unit;
            let elems = document.querySelectorAll('.default_unit');
            elems.forEach((elem) => {
                elem.value = DefaultUnit;
            })
        }
        $('.material_name').on('input', function() {
            MaterialName = $(this).val();
            $('.material_name').val(MaterialName);

        })
        $(document).ready(function() {
            $('.optional_field').on('input', function() {
                let field = $(this).attr('data-option');
                $(`.${field}`).val(0)
            })
        })
        $('.unit-field').on('click', function() {
            let value = $(this).val();
            $(this).attr('data-oldValue', value);
        })
        $('.unit-field').on('change', function() {
            let value = $(this).val();
            let oldValue = $(this).attr('data-oldValue');
            $(`[data-value1="${oldValue}"]`).removeAttr('hidden');
            $(`[data-value1="${value}"]`).attr('hidden', "hidden");
        });
        const materialDivision = document.querySelector('#material_division_id');
        const materialClass = document.querySelector('#material_class_id');
        materialDivision.addEventListener('change', async (e) => {
            let value = e.target.value;
            let url = `{{ route('material_class') }}/${value}`;

            let response = await fetch(url);
            let data = await response.json();

            materialClass.innerHTML = '<option value="" selected hidden>Choose Class</option>';
            data.forEach((material_class) => {
                materialClass.innerHTML +=
                    `<option value="${material_class.id}">${material_class.name}</option>`
            })
        })

        const fractions = document.querySelectorAll('.fraction-input');
        fractions.forEach(frac => {
            let target = frac.dataset.target;
            frac.addEventListener('keydown', (e) => {
                let isNumber = isFinite(e.key);

                if (!isNumber && e.key !== 'Backspace') {
                    e.preventDefault();
                }
            })
            frac.addEventListener('input', (e) => {
                let whole = parseInt(frac.querySelector('.whole').textContent || 0);
                let sup = parseInt(frac.querySelector('.sup').textContent || 0);
                let sub = parseInt(frac.querySelector('.sub').textContent || 0);

                if (sub == 0) {
                    document.querySelector(`#${target}`).value = whole;
                    return false;

                }
                if (sub < sup) {
                    frac.dataset.error = 'Denominator should be non zero and greater than Numerator';
                    document.querySelector(`#${target}`).value = '';
                    return false;
                }

                let value = ((sub * whole) + sup) / sub;
                frac.dataset.error = '';
                document.querySelector(`#${target}`).value = value.toFixed(3);
            })
        })

        document.querySelector('#default_unit').addEventListener('blur', (e) => {
            let unit = e.target.value;
            console.log(unit);
            updateDefaultUnit(unit);
            document.querySelector('#prices').placeholder = `$ / ${unit}`;
            document.querySelector('#production_unit').textContent = unit;
        });
        let x = 1;
        $('.add-more').click(function() {
            $('.more-material').append(`@include('components.user.matfield')`);
            x++;
            document.dispatchEvent(new Event('DOMContentLoaded'))
        });
        $('.more-material').on('click', '.remove', function() {
            $(this).parents('.mat-field').remove();
            x--;
        });

        document.addEventListener('DOMContentLoaded', () => {
            let otherMaterials = document.querySelectorAll('.other_material');
            let otherMaterialUnits = document.querySelectorAll('.other_material_unit');

            otherMaterials.forEach((elem, index) => {
                elem.addEventListener('change', (e) => {
                    let options = e.target.querySelectorAll('option');
                    options.forEach((option) => {
                        if(option.selected) {
                            otherMaterialUnits[index].value = option.dataset.unit || '';
                            return
                        }
                    })
                })
            })
        })
    </script>
@endsection()
