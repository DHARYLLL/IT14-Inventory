@extends('layouts.layout')
@section('title', 'Equipments')

@section('content')
@section('head', 'Add Package')
@section('name', 'Staff')

<div class="d-flex align-items-center justify-content-end mb-4">
    <a href="{{ route('Package.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2">
        <i class="bi bi-arrow-left-circle"></i> <span>Back</span>
    </a>
</div>

<div class="card shadow-sm p-4 bg-white border-0 rounded-3 form-container">
    <form action="{{ route('Package.store') }}" method="POST">
        @csrf

        {{-- Package Name --}}
        <div class="row g-3 mb-3">
            <div class="col-md-12">
                <label class="form-label fw-semibold text-secondary">Package Name</label>
                <input type="text" class="form-control" placeholder="Enter package name" name="pkg_name" required>
                @error('pkg_name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        {{-- Inclusions List --}}
        <div class="mb-4">
            <label class="form-label fw-semibold text-secondary">Inclusions</label>

            <div id="inclusion-list">
                <div class="d-flex align-items-center mb-2 inclusion-item gap-2">
                    <div class="number-box d-flex align-items-center justify-content-center rounded bg-light border"
                        style="width: 38px; height: 38px; font-weight: 500;">1</div>
                    <input type="text" name="pkg_inclusion[]" class="form-control"
                        placeholder="Enter inclusion item">
                    <button type="button"
                        class="btn btn-outline-danger d-flex align-items-center justify-content-center remove-inclusion"
                        style="width: 38px; height: 38px;">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>


            <button type="button" class="btn btn-outline-success mt-2" id="add-inclusion">
                <i class="bi bi-plus-circle"></i> Add More
            </button>
        </div>

        {{-- Submit Button --}}
        <div class="row mt-3">
            <div class="col">
                <button type="submit" class="btn submit-btn w-100 py-2">Submit</button>
            </div>
        </div>
    </form>
</div>

{{-- JS to dynamically add/remove inclusions --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addBtn = document.getElementById('add-inclusion');
        const list = document.getElementById('inclusion-list');

        addBtn.addEventListener('click', function() {
            const count = list.querySelectorAll('.inclusion-item').length + 1;
            const newItem = document.createElement('div');
            newItem.classList.add('input-group', 'mb-2', 'inclusion-item');
            newItem.innerHTML = `
                    <span class="input-group-text bg-light border">${count}</span>
                    <input type="text" name="pkg_inclusion[]" class="form-control" placeholder="Enter inclusion item">
                    <button type="button" class="btn btn-outline-danger remove-inclusion">
                        <i class="bi bi-trash"></i>
                    </button>
                `;
            list.appendChild(newItem);
        });

        list.addEventListener('click', function(e) {
            if (e.target.closest('.remove-inclusion')) {
                e.target.closest('.inclusion-item').remove();
                // Reorder numbering
                list.querySelectorAll('.inclusion-item').forEach((item, index) => {
                    item.querySelector('.input-group-text').textContent = index + 1;
                });
            }
        });
    });
</script>
@endsection
