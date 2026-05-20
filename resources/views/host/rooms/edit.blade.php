@extends('host.layouts.app')

@section('title', 'Edit Room')

@section('content')

<div style="font-family: sans-serif; padding: 20px; color: #333; max-width: 800px; margin: 0 auto;">

    <!-- Khối tiêu đề & Nút quay lại -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 style="font-size: 24px; font-weight: 600; margin: 0;">Edit Room</h1>
        <a href="{{ route('host.rooms.index') }}" style="color: #1a73e8; text-decoration: none; font-weight: 500; font-size: 14px;">
            ← Back to List
        </a>
    </div>

    <!-- Thông báo thành công -->
    @if(session('success'))
        <div style="padding: 12px 16px; background-color: #e6f4ea; color: #137333; border-radius: 6px; margin-bottom: 20px; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Thông báo lỗi kiểm tra dữ liệu (Validation) -->
    @if($errors->any())
        <div style="padding: 12px 16px; background-color: #fce8e6; color: #c5221f; border-radius: 6px; margin-bottom: 20px; font-size: 14px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- 
    |--------------------------------------------------------------------------
    | FORM CẬP NHẬT THÔNG TIN PHÒNG
    |--------------------------------------------------------------------------
    -->
    <form method="POST" action="{{ route('host.rooms.update', $room) }}"
          style="background: white; padding: 28px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 30px;">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="display: block; font-size: 14px; font-weight: 600; color: #555; margin-bottom: 8px;">Room Code</label>
                <input type="text" name="room_code" value="{{ old('room_code', $room->room_code) }}" placeholder="e.g. R-101"
                       style="width: 100%; padding: 10px 12px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; box-sizing: border-box; color: #333;">
            </div>
            <div>
                <label style="display: block; font-size: 14px; font-weight: 600; color: #555; margin-bottom: 8px;">Room Name</label>
                <input type="text" name="room_name" value="{{ old('room_name', $room->room_name) }}" placeholder="e.g. Deluxe Suite"
                       style="width: 100%; padding: 10px 12px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; box-sizing: border-box; color: #333;">
            </div>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 14px; font-weight: 600; color: #555; margin-bottom: 8px;">Description</label>
            <textarea name="description" placeholder="Describe the room details..."
                      style="width: 100%; padding: 10px 12px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; box-sizing: border-box; color: #333; min-height: 100px; font-family: sans-serif; resize: vertical;">{{ old('description', $room->description) }}</textarea>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px; margin-bottom: 28px;">
            <div>
                <label style="display: block; font-size: 14px; font-weight: 600; color: #555; margin-bottom: 8px;">Price (VND)</label>
                <input type="number" name="price" value="{{ old('price', $room->price) }}"
                       style="width: 100%; padding: 10px 12px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; box-sizing: border-box; color: #333;">
            </div>
            <div>
                <label style="display: block; font-size: 14px; font-weight: 600; color: #555; margin-bottom: 8px;">Capacity</label>
                <input type="number" name="capacity" value="{{ old('capacity', $room->capacity) }}"
                       style="width: 100%; padding: 10px 12px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; box-sizing: border-box; color: #333;">
            </div>
            <div>
                <label style="display: block; font-size: 14px; font-weight: 600; color: #555; margin-bottom: 8px;">Status</label>
                <select name="status" style="width: 100%; padding: 10px 12px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; box-sizing: border-box; color: #333; background-color: white;">
                    <option value="available" {{ $room->status == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="maintenance" {{ $room->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    <option value="occupied" {{ $room->status == 'occupied' ? 'selected' : '' }}>Occupied</option>
                    <option value="cleaning" {{ $room->status == 'cleaning' ? 'selected' : '' }}>Cleaning</option>
                </select>
            </div>
        </div>

        <button type="submit" style="background: #1a73e8; color: white; border: none; padding: 10px 24px; border-radius: 6px; font-size: 14px; font-weight: 500; cursor: pointer;">
            Update Room Info
        </button>
    </form>

    <!-- 
    |--------------------------------------------------------------------------
    | KHU VỰC QUẢN LÝ HÌNH ẢNH PHÒNG
    |--------------------------------------------------------------------------
    -->
    <div style="background: white; padding: 28px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <h2 style="font-size: 18px; font-weight: 600; margin-top: 0; margin-bottom: 16px; color: #444;">Room Images</h2>

        <!-- Form Tải ảnh lên -->
        <form method="POST" action="{{ route('host.rooms.images.store', $room) }}" enctype="multipart/form-data"
              style="background: #f8f9fa; padding: 16px; border-radius: 6px; border: 1px dashed #dadce0; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 24px;">
            @csrf
            <input type="file" name="images[]" multiple accept="image/*" style="font-size: 14px; color: #555;">
            <button type="submit" style="background: #137333; color: white; border: none; padding: 8px 16px; border-radius: 6px; font-size: 14px; font-weight: 500; cursor: pointer;">
                Upload Images
            </button>
        </form>

        <!-- Danh sách ảnh hiển thị -->
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;">
            @forelse($room->images as $image)
                <div style="border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; background: #fff; box-shadow: 0 1px 2px rgba(0,0,0,0.05); display: flex; flex-direction: column; justify-content: space-between;">
                    
                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Room Image" 
                         style="width: 100%; height: 150px; object-fit: cover; display: block;">

                    <div style="padding: 12px; background: #fafafa; border-top: 1px solid #f0f0f0;">
                        @if($image->is_main)
                            <div style="color: #137333; font-weight: 600; font-size: 13px; text-align: center; padding: 6px 0; margin-bottom: 8px; background: #e6f4ea; border-radius: 4px;">
                                ✓ Main Image
                            </div>
                        @else
                            <form method="POST" action="{{ route('host.rooms.images.main', $image) }}">
                                @csrf
                                <button type="submit" style="width: 100%; padding: 6px; border: 1px solid #f59e0b; background: white; color: #d97706; border-radius: 4px; font-size: 12px; font-weight: 500; cursor: pointer; margin-bottom: 8px;">
                                    Set Main
                                </button>
                            </form>
                        @endif

                        <!-- Form Xóa ảnh -->
                        <form method="POST" action="{{ route('host.rooms.images.destroy', $image) }}"
                              onsubmit="return confirm('Delete this image?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="width: 100%; padding: 6px; border: none; background: #fce8e6; color: #c5221f; border-radius: 4px; font-size: 12px; font-weight: 500; cursor: pointer;">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; padding: 24px; text-align: center; color: #777; font-style: italic; background: #f9f9f9; border-radius: 6px;">
                    No images uploaded yet.
                </div>
            @endforelse
        </div>
    </div>

</div>

@endsection