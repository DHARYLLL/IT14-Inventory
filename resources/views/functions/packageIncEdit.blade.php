@extends('shows/packageInclusionShow')

@section('package-edit')
    <form action="{{ route('Package-Inclusion.update', $pkgIncData->id) }}" method="post">
        @csrf
        @method('put')

        <div class="row">
            <div class="col col-12 p-3">
                <input type="text" name="pkgInc" class="form-control" value="{{ $pkgIncData->pkg_inclusion }}">
                @error('pkgInc')
                    <p>{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col col-6">
                <button type="submit" class="btn btn-green w-100">Save</button>
            </div>
            <div class="col col-6">
                <a href="{{ route('Package.show', $pkgIncData->package_id) }}"
                    class="btn btn-outline-success w-100">Cancel</a>
            </div>
        </div>

    </form>
@endsection
