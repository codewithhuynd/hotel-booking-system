@extends('host.layouts.app')

@section('title', 'Edit User')

@section('content')

<div style="font-family: sans-serif; padding: 20px; color: #333; max-width: 600px;">
    
    <!-- Tiêu đề & Nút quay lại -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 style="font-size: 24px; font-weight: 600; margin: 0;">Edit User</h1>
        <a href="{{ route('host.users.index') }}" style="color: #1a73e8; text-decoration: none; font-weight: 500; font-size: 14px;">
            ← Back to List
        </a>
    </div>

    <!-- Form chỉnh sửa -->
    <form method="POST" action="{{ route('host.users.update', $user) }}"
          style="background: white; padding: 28px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        @csrf
        @method('PUT')

        <!-- Ô nhập Name -->
        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 14px; font-weight: 600; color: #555; margin-bottom: 8px;">Name</label>
            <input type="text" name="full_name" value="{{ $user->full_name }}" 
                   style="width: 100%; padding: 10px 12px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; box-sizing: border-box; color: #333;">
        </div>

        <!-- Ô nhập Phone -->
        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 14px; font-weight: 600; color: #555; margin-bottom: 8px;">Phone</label>
            <input type="text" name="phone" value="{{ $user->phone }}" 
                   style="width: 100%; padding: 10px 12px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; box-sizing: border-box; color: #333;">
        </div>

        <!-- Ô nhập Birthday -->
        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 14px; font-weight: 600; color: #555; margin-bottom: 8px;">Birthday</label>
            <input type="date" name="birthday" value="{{ $user->birthday }}" 
                   style="width: 100%; padding: 10px 12px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; box-sizing: border-box; color: #333; font-family: sans-serif;">
        </div>

        <!-- Ô chọn Role -->
        <div style="margin-bottom: 28px;">
            <label style="display: block; font-size: 14px; font-weight: 600; color: #555; margin-bottom: 8px;">Role</label>
            <select name="role" 
                    style="width: 100%; padding: 10px 12px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; box-sizing: border-box; color: #333; background-color: white;">
                <option value="guest" @selected($user->role=='guest')>Guest</option>
                <option value="host" @selected($user->role=='host')>Host</option>
            </select>
        </div>

        <!-- Nút bấm Action -->
        <div style="display: flex; gap: 12px; align-items: center;">
            <button type="submit" 
                    style="background: #1a73e8; color: white; border: none; padding: 10px 24px; border-radius: 6px; font-size: 14px; font-weight: 500; cursor: pointer;">
                Save Changes
            </button>
            <a href="{{ route('host.users.index') }}" 
               style="color: #5f6368; text-decoration: none; font-size: 14px; font-weight: 500; padding: 10px 16px; border-radius: 6px; border: 1px solid #dadce0; background: white;">
                Cancel
            </a>
        </div>
    </form>

</div>

@endsection