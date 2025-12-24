<x-app-layout>
    <x-slot name="header">
        <h2>Assign Quiz to Users</h2>
    </x-slot>

    <div class="card" style="max-width: 900px; margin: 0 auto;">
        <a href="{{ route('quiz.index') }}" style="color: #848177; text-decoration: none; margin-bottom: 15px; display: inline-block; font-size: 13px;">← Back to Quiz List</a>

        <div style="background: linear-gradient(180deg, #848177 0%, #000000 100%); color: white; padding: 15px 20px; border-radius: 8px; margin-bottom: 20px;">
            <h3 style="margin: 0; font-size: 18px; font-weight: 600;">Quiz Question</h3>
            <p style="margin: 5px 0 0 0; font-size: 13px; opacity: 0.9;">{{ Str::limit($quiz->question, 100) }}</p>
        </div>

        @if(session('success'))
            <div class="alert-box alert-success" style="margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('info'))
            <div class="alert-box alert-info" style="margin-bottom: 20px; background: #dbeafe; color: #1e40af; padding: 12px; border-radius: 5px;">
                {{ session('info') }}
            </div>
        @endif

        <form method="POST" action="{{ route('quiz.assign-quiz.store', $quiz) }}">
            @csrf

            <div class="form-group" style="margin-bottom: 15px;">
                <label for="user_ids" style="display: block; color: #333; font-size: 13px; font-weight: 500; margin-bottom: 6px;">Select Users to Assign</label>
                <select id="user_ids" name="user_ids[]" multiple required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 13px; background: white; min-height: 150px;">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ in_array($user->id, old('user_ids', [])) ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>               
                @error('user_ids')
                    <div style="color: #ef4444; margin-top: 4px; font-size: 12px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label for="due_date" style="display: block; color: #333; font-size: 13px; font-weight: 500; margin-bottom: 6px;">Due Date (Optional)</label>
                <input type="datetime-local" id="due_date" name="due_date" value="{{ old('due_date') }}" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 13px; background: white;">
                @error('due_date')
                    <div style="color: #ef4444; margin-top: 4px; font-size: 12px;">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-login" style="padding: 10px 20px; font-size: 14px;">Assign to Selected Users</button>
        </form>

        @if($assignments->count() > 0)
            <div style="margin-top: 40px; border-top: 2px solid #e5e5e5; padding-top: 20px;">
                <h3 style="margin: 0 0 15px 0; font-size: 16px; font-weight: 600;">Current Assignments</h3>
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f5f5f5; border-bottom: 2px solid #ddd;">
                            <th style="padding: 12px; text-align: left;">User</th>
                            <th style="padding: 12px; text-align: left;">Status</th>
                            <th style="padding: 12px; text-align: left;">Due Date</th>
                            <th style="padding: 12px; text-align: left;">Assigned At</th>
                            <th style="padding: 12px; text-align: left;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assignments as $assignment)
                            <tr style="border-bottom: 1px solid #eee;">
                                <td style="padding: 12px;">
                                    @if($assignment->user)
                                        {{ $assignment->user->name }}<br><small style="color: #666;">{{ $assignment->user->email }}</small>
                                    @else
                                        <span style="color: #999;">User Deleted</span>
                                    @endif
                                </td>
                                <td style="padding: 12px;">
                                    @if($assignment->status == 'pending')
                                        <span style="background: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 500;">Pending</span>
                                    @elseif($assignment->status == 'in_progress')
                                        <span style="background: #dbeafe; color: #1e40af; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 500;">In Progress</span>
                                    @else
                                        <span style="background: #d1fae5; color: #065f46; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 500;">Completed</span>
                                    @endif
                                </td>
                                <td style="padding: 12px;">
                                    @if($assignment->due_date)
                                        {{ $assignment->due_date->format('M d, Y H:i') }}
                                    @else
                                        <span style="color: #999;">No due date</span>
                                    @endif
                                </td>
                                <td style="padding: 12px;">{{ $assignment->created_at->format('M d, Y') }}</td>
                                <td style="padding: 12px;">
                                    <form action="{{ route('quiz.assignment.remove', $assignment) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to remove this assignment?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; padding: 0; font-size: 14px;">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>

