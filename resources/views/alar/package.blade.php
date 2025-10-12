@extends('layouts.layout')
@section('title', 'Packages')

@section('content')
@section('head', 'Packages')
@section('name', 'Staff')

<div class="d-flex align-items-center justify-content-between mb-2">
    <h2 class="fw-semibold text-success">Packages</h2>

    <!-- Trigger Modal -->
    <button class="btn btn-green d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addPackageModal">
        <i class="bi bi-plus-lg"></i><span>Add Package</span>
    </button>
</div>

{{-- Table --}}
<table class="modern-table table-hover mb-0">
    <thead>
        <tr>
            <th class="fw-semibold">Package</th>
            <th class="fw-semibold">Action</th>
        </tr>
    </thead>
    <tbody>
        @if ($pacData->isEmpty())
            <tr>
                <td colspan="2" class="text-center text-secondary py-3">No packages available.</td>
            </tr>
        @else
            @foreach ($pacData as $row)
                <tr>
                    <td>{{ $row->pkg_name }}</td>
                    <td>
                        <a href="{{ route('Package.show', $row->id) }}" class="btn btn-outline-success btn-md">
                            <i class="fi fi-rr-eye" data-bs-toggle="tooltip" data-bs-placement="top" title="View"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>


<!-- ADD PACKAGE MODAL -->

<div class="modal fade" id="addPackageModal" tabindex="-1" aria-labelledby="addPackageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content package-modal">
            <div class="modal-header modal-green">
                <h5 class="modal-title fw-bold text-white" id="addPackageModalLabel">Add New Package</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('Package.store') }}" method="POST">
                    @csrf

                    {{-- Package Name --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Package Name</label>
                        <input type="text" class="form-control form-input" placeholder="Enter package name"
                            name="pkg_name" required>
                        @error('pkg_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Inclusions --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Inclusions</label>

                        <div id="inclusion-list">
                            <div class="d-flex align-items-center mb-2 inclusion-item gap-2">
                                <input type="text" name="pkg_inclusion[]" class="form-control form-input"
                                    placeholder="Enter inclusion item">
                                <button type="button"
                                    class="btn btn-outline-danger d-flex align-items-center justify-content-center remove-inclusion"
                                    style="width: 38px; height: 38px;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>

                        <button type="button" class="btn btn-green mt-2" id="add-inclusion">
                            <i class="bi bi-plus-circle"></i> Add New Inclusion
                        </button>
                    </div>

                    {{-- Footer --}}
                    <div class="modal-footer justify-content-end mt-4">
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-success modal-btn" data-bs-dismiss="modal">
                                <i class="bi bi-arrow-left"></i> Cancel
                            </button>
                            <button type="submit" class="btn btn-green modal-btn">
                                <i class="bi bi-plus-circle"></i> Add Package
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addBtn = document.getElementById('add-inclusion');
        const list = document.getElementById('inclusion-list');

        addBtn.addEventListener('click', function() {
            const newItem = document.createElement('div');
            newItem.classList.add('d-flex', 'align-items-center', 'mb-2', 'inclusion-item', 'gap-2');
            newItem.innerHTML = `
                <input type="text" name="pkg_inclusion[]" class="form-control form-input" placeholder="Enter inclusion item">
                <button type="button" class="btn btn-outline-danger d-flex align-items-center justify-content-center remove-inclusion" style="width: 38px; height: 38px;">
                    <i class="bi bi-trash"></i>
                </button>
            `;
            list.appendChild(newItem);
        });

        list.addEventListener('click', function(e) {
            if (e.target.closest('.remove-inclusion')) {
                e.target.closest('.inclusion-item').remove();
            }
        });
    });
</script>

@endsection
