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

        <div class="row justify-content-center align-items-center">
            <div class="col col-2">
                <a href="{{ route('Package.show', $pkgIncData->package_id) }}" class="btn btn-outline-danger w-100"><i
                        class="bi bi-x-lg px-2"></i>Cancel</a>
            </div>
            <div class="col col-2">
                <button type="submit" class="btn btn-green w-100"><i class="bi bi-floppy px-2"></i>Save</button>
            </div>
        </div>

    </form>
@endsection
