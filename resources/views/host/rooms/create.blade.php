@extends('host.layouts.app')

@section('title', 'Create Room')

@section('content')

<div style="font-family: sans-serif; padding: 20px; color: #333; max-width: 700px;">
    
    <!-- Tiêu đề và nút quay lại -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 style="font-size: 24px; font-weight: 600; margin: 0;">Create Room</h1>
        <a href="{{ route('host.rooms.index') }}" style="color: #1a73e8; text-decoration: none; font-weight: 500; font-size: 14px;">
            ← Back to List
        </a>
    </div>

    <!-- Khung hiển thị lỗi (Validation) -->
    @if($errors->any())
        <div style="background-color: #fce8e6; color: #c5221f; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form nhập thông tin -->
    <form method="POST" action="{{ route('host.rooms.store') }}"
          style="background: white; padding: 28px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        @csrf

        <!-- Mã phòng & Tên phòng -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="display: block; font-size: 14px; font-weight: 600; color: #555; margin-bottom: 8px;">Room Code</label>
                <input type="text" name="room_code" value="{{ old('room_code') }}" placeholder="e.g. R-101"
                       style="width: 100%; padding: 10px 12px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; box-sizing: border-box; color: #333;">
            </div>
            <div>
                <label style="display: block; font-size: 14px; font-weight: 600; color: #555; margin-bottom: 8px;">Room Name</label>
                <input type="text" name="room_name" value="{{ old('room_name') }}" placeholder="e.g. Deluxe Suite"
                       style="width: 100%; padding: 10px 12px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; box-sizing: border-box; color: #333;">
            </div>
        </div>

        <!-- Mô tả phòng -->
        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 14px; font-weight: 600; color: #555; margin-bottom: 8px;">Description</label>
            <textarea name="description" placeholder="Enter room details, view, bed type..."
                      style="width: 100%; padding: 10px 12px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; box-sizing: border-box; color: #333; min-height: 100px; font-family: sans-serif; resize: vertical;">{{ old('description') }}</textarea>
        </div>

        <!-- Giá, Sức chứa & Trạng thái -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 20px; margin-bottom: 28px;">
            <div>
                <label style="display: block; font-size: 14px; font-weight: 600; color: #555; margin-bottom: 8px;">Price (VND)</label>
                <input type="number" name="price" value="{{ old('price') }}" placeholder="Price"
                       style="width: 100%; padding: 10px 12px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; box-sizing: border-box; color: #333;">
            </div>
            <div>
                <label style="display: block; font-size: 14px; font-weight: 600; color: #555; margin-bottom: 8px;">Capacity</label>
                <input type="number" name="capacity" value="{{ old('capacity') }}" placeholder="Guests"
                       style="width: 100%; padding: 10px 12px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; box-sizing: border-box; color: #333;">
            </div>
            <div>
                <label style="display: block; font-size: 14px; font-weight: 600; color: #555; margin-bottom: 8px;">Status</label>
                <select name="status" 
                        style="width: 100%; padding: 10px 12px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; box-sizing: border-box; color: #333; background-color: white; height: 38px;">
                    <option value="available">Available</option>
                    <option value="booked">Booked</option>
                    <option value="occupied">Occupied</option>
                    <option value="cleaning">Cleaning</option>
                </select>
            </div>
        </div>

        <!-- Nút xử lý -->
        <div style="display: flex; gap: 12px; align-items: center;">
            <button type="submit" 
                    style="background: #1a73e8; color: white; border: none; padding: 10px 24px; border-radius: 6px; font-size: 14px; font-weight: 500; cursor: pointer;">
                Create Room
            </button>
            <a href="{{ route('host.rooms.index') }}" 
               style="color: #5f6368; text-decoration: none; font-size: 14px; font-weight: 500; padding: 9px 16px; border-radius: 6px; border: 1px solid #dadce0; background: white;">
                Cancel
            </a>
        </div>
    </form>

</div>

@endsection