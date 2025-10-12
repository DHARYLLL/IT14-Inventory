@extends('layouts.layout')
@section('title', 'Add Equipment')

@section('content')
@section('head', 'Equipments')

<div class="equipment-add-container">
    <div class="equipment-add-header">
        <a href="{{ url()->previous() }}" class="back-btn">Back</a>
    </div>

    <div class="equipment-card">
        <form action="{{ route('Equipment.index') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Equipment Name:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" required min="1">
            </div>

            <div class="button-container">
                <button type="submit" class="add-btn">Add Equipment</button>
            </div>
        </form>
    </div>
</div>
@endsection
