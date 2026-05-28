@extends('host.layouts.app')

@section('title', 'Chỉnh sửa phòng')

@section('content')

<div style="font-family: Arial, sans-serif; padding: 24px; color: #0f172a; max-width: 1200px; margin: 0 auto;">

    <!-- HEADER -->
    <div style="display: flex; justify-content: space-between; align-items: center; gap: 20px; margin-bottom: 28px; flex-wrap: wrap;">

        <div>
            <p style="font-size: 12px; color: #64748b; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 6px;">
                Quản lý phòng
            </p>

            <h1 style="font-size: 32px; font-weight: 800; color: #0f172a; margin: 0;">
                Chỉnh sửa phòng
            </h1>
        </div>

        <a href="{{ route('host.rooms.index') }}"
            style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 18px; border-radius: 12px; background: white; border: 1px solid #e2e8f0; color: #334155; text-decoration: none; font-weight: 600; transition: 0.2s;">
            ← Quay lại danh sách
        </a>

    </div>

    <!-- SUCCESS -->
    @if(session('success'))
        <div style="padding: 16px 18px; background: #ecfdf3; color: #166534; border: 1px solid #bbf7d0; border-radius: 16px; margin-bottom: 24px; font-size: 14px; font-weight: 600;">
            {{ session('success') }}
        </div>
    @endif

    <!-- ERRORS -->
    @if($errors->any())
        <div style="padding: 18px; background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; border-radius: 16px; margin-bottom: 24px; font-size: 14px;">
            <div style="font-weight: 700; margin-bottom: 10px;">
                Vui lòng kiểm tra lại thông tin:
            </div>

            <ul style="padding-left: 20px; margin: 0;">
                @foreach($errors->all() as $error)
                    <li style="margin-bottom: 6px;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- FORM -->
    <form method="POST"
          action="{{ route('host.rooms.update', $room) }}"
          style="background: white;
                 border-radius: 28px;
                 padding: 32px;
                 box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
                 border: 1px solid #e2e8f0;
                 margin-bottom: 32px;">

        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 24px; margin-bottom: 24px;">

            <!-- ROOM CODE -->
            <div>
                <label style="display: block; margin-bottom: 10px; font-size: 13px; font-weight: 700; color: #475569;">
                    Mã phòng
                </label>

                <input type="text"
                       name="room_code"
                       value="{{ old('room_code', $room->room_code) }}"
                       placeholder="Ví dụ: R-101"
                       style="width: 100%;
                              padding: 14px 16px;
                              border-radius: 14px;
                              border: 1px solid #cbd5e1;
                              font-size: 14px;
                              color: #0f172a;
                              outline: none;
                              background: #f8fafc;">
            </div>

            <!-- ROOM NAME -->
            <div>
                <label style="display: block; margin-bottom: 10px; font-size: 13px; font-weight: 700; color: #475569;">
                    Tên phòng
                </label>

                <input type="text"
                       name="room_name"
                       value="{{ old('room_name', $room->room_name) }}"
                       placeholder="Ví dụ: Suite cao cấp"
                       style="width: 100%;
                              padding: 14px 16px;
                              border-radius: 14px;
                              border: 1px solid #cbd5e1;
                              font-size: 14px;
                              color: #0f172a;
                              outline: none;
                              background: #f8fafc;">
            </div>

        </div>

        <!-- DESCRIPTION -->
        <div style="margin-bottom: 24px;">

            <label style="display: block; margin-bottom: 10px; font-size: 13px; font-weight: 700; color: #475569;">
                Mô tả phòng
            </label>

            <textarea name="description"
                      placeholder="Nhập mô tả chi tiết về phòng..."
                      style="width: 100%;
                             min-height: 140px;
                             padding: 16px;
                             border-radius: 16px;
                             border: 1px solid #cbd5e1;
                             background: #f8fafc;
                             resize: vertical;
                             outline: none;
                             font-size: 14px;
                             color: #0f172a;
                             font-family: Arial, sans-serif;">{{ old('description', $room->description) }}</textarea>

        </div>

        <!-- GRID -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 24px; margin-bottom: 30px;">

            <!-- PRICE -->
            <div>
                <label style="display: block; margin-bottom: 10px; font-size: 13px; font-weight: 700; color: #475569;">
                    Giá phòng (VND)
                </label>

                <input type="number"
                       name="price"
                       value="{{ old('price', $room->price) }}"
                       style="width: 100%;
                              padding: 14px 16px;
                              border-radius: 14px;
                              border: 1px solid #cbd5e1;
                              background: #f8fafc;
                              font-size: 14px;
                              color: #0f172a;">
            </div>

            <!-- CAPACITY -->
            <div>
                <label style="display: block; margin-bottom: 10px; font-size: 13px; font-weight: 700; color: #475569;">
                    Sức chứa
                </label>

                <input type="number"
                       name="capacity"
                       value="{{ old('capacity', $room->capacity) }}"
                       style="width: 100%;
                              padding: 14px 16px;
                              border-radius: 14px;
                              border: 1px solid #cbd5e1;
                              background: #f8fafc;
                              font-size: 14px;
                              color: #0f172a;">
            </div>

            <!-- STATUS -->
            <div>
                <label style="display: block; margin-bottom: 10px; font-size: 13px; font-weight: 700; color: #475569;">
                    Trạng thái
                </label>

                <select name="status"
                        style="width: 100%;
                               padding: 14px 16px;
                               border-radius: 14px;
                               border: 1px solid #cbd5e1;
                               background: #f8fafc;
                               font-size: 14px;
                               color: #0f172a;">

                    <option value="maintenance" {{ $room->status == 'maintenance' ? 'selected' : '' }}>
                        Đang bảo trì
                    </option>

                    <option value="cleaning" {{ $room->status == 'cleaning' ? 'selected' : '' }}>
                        Đang dọn dẹp
                    </option>

                </select>
            </div>

        </div>

        <!-- BUTTON -->
        <button type="submit"
                style="padding: 14px 28px;
                       border: none;
                       border-radius: 14px;
                       background: linear-gradient(135deg, #2563eb, #1d4ed8);
                       color: white;
                       font-size: 14px;
                       font-weight: 700;
                       cursor: pointer;
                       box-shadow: 0 10px 20px rgba(37, 99, 235, 0.25);">
            Cập nhật thông tin phòng
        </button>

    </form>

    <!-- IMAGES -->
    <div style="background: white;
                border-radius: 28px;
                padding: 32px;
                border: 1px solid #e2e8f0;
                box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);">

        <!-- TITLE -->
        <div style="display: flex; justify-content: space-between; align-items: center; gap: 20px; margin-bottom: 24px; flex-wrap: wrap;">

            <div>
                <h2 style="font-size: 24px; font-weight: 800; color: #0f172a; margin-bottom: 6px;">
                    Hình ảnh phòng
                </h2>

                <p style="font-size: 14px; color: #64748b;">
                    Quản lý hình ảnh hiển thị của phòng khách sạn.
                </p>
            </div>

        </div>

        <!-- UPLOAD -->
        <form method="POST"
              action="{{ route('host.rooms.images.store', $room) }}"
              enctype="multipart/form-data"
              style="padding: 24px;
                     border-radius: 20px;
                     border: 2px dashed #cbd5e1;
                     background: #f8fafc;
                     margin-bottom: 30px;
                     display: flex;
                     justify-content: space-between;
                     align-items: center;
                     gap: 16px;
                     flex-wrap: wrap;">

            @csrf

            <input type="file"
                   name="images[]"
                   multiple
                   accept="image/*"
                   style="font-size: 14px; color: #334155;">

            <button type="submit"
                    style="padding: 12px 22px;
                           border: none;
                           border-radius: 12px;
                           background: linear-gradient(135deg, #16a34a, #15803d);
                           color: white;
                           font-size: 14px;
                           font-weight: 700;
                           cursor: pointer;">
                Tải ảnh lên
            </button>

        </form>

        <!-- IMAGE GRID -->
        <div style="display: grid;
                    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
                    gap: 24px;">

            @forelse($room->images as $image)

                <div style="background: white;
                            border-radius: 22px;
                            overflow: hidden;
                            border: 1px solid #e2e8f0;
                            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.06);">

                    <!-- IMAGE -->
                    <img src="{{ asset('storage/' . $image->image_path) }}"
                         alt="Ảnh phòng"
                         style="width: 100%;
                                height: 190px;
                                object-fit: cover;
                                display: block;">

                    <!-- BODY -->
                    <div style="padding: 18px;">

                        @if($image->is_main)

                            <div style="padding: 10px 14px;
                                        border-radius: 12px;
                                        background: #ecfdf3;
                                        color: #166534;
                                        font-size: 13px;
                                        font-weight: 700;
                                        text-align: center;
                                        margin-bottom: 12px;">

                                ✓ Ảnh đại diện chính

                            </div>

                        @else

                            <form method="POST"
                                  action="{{ route('host.rooms.images.main', $image) }}"
                                  style="margin-bottom: 12px;">

                                @csrf

                                <button type="submit"
                                        style="width: 100%;
                                               padding: 11px;
                                               border-radius: 12px;
                                               border: 1px solid #f59e0b;
                                               background: #fff7ed;
                                               color: #d97706;
                                               font-size: 13px;
                                               font-weight: 700;
                                               cursor: pointer;">
                                    Đặt làm ảnh chính
                                </button>

                            </form>

                        @endif

                        <!-- DELETE -->
                        <form method="POST"
                              action="{{ route('host.rooms.images.destroy', $image) }}"
                              onsubmit="return confirm('Bạn có chắc muốn xóa ảnh này không?');">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    style="width: 100%;
                                           padding: 11px;
                                           border: none;
                                           border-radius: 12px;
                                           background: #fef2f2;
                                           color: #dc2626;
                                           font-size: 13px;
                                           font-weight: 700;
                                           cursor: pointer;">

                                Xóa ảnh

                            </button>

                        </form>

                    </div>

                </div>

            @empty

                <div style="grid-column: 1 / -1;
                            padding: 50px 20px;
                            text-align: center;
                            border-radius: 22px;
                            background: #f8fafc;
                            border: 2px dashed #cbd5e1;
                            color: #64748b;">

                    <div style="font-size: 16px; font-weight: 700; margin-bottom: 8px;">
                        Chưa có hình ảnh nào
                    </div>

                    <div style="font-size: 14px;">
                        Hãy tải lên hình ảnh đầu tiên cho phòng này.
                    </div>

                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection