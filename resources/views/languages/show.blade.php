<x-app-layout>
    <x-slot name="header">
        <h2>Language Details</h2>
    </x-slot>

    <div class="card" style="max-width: 800px; margin: 0 auto;">
        <a href="{{ route('languages.index') }}" style="color: #848177; text-decoration: none; margin-bottom: 15px; display: inline-block; font-size: 13px;">← Back to Languages</a>

        <div style="background: linear-gradient(180deg, #848177 0%, #000000 100%); color: white; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
            <h3 style="margin: 0; font-size: 24px; font-weight: 600;">{{ $language->name }}</h3>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 20px;">
            <div style="background: #f5f5f5; padding: 15px; border-radius: 8px;">
                <div style="color: #666; font-size: 12px; text-transform: uppercase; margin-bottom: 5px;">Created By</div>
                <div style="color: #333; font-size: 16px; font-weight: 600;">
                    {{ $language->creator->name ?? 'N/A' }}
                </div>
            </div>
            <div style="background: #f5f5f5; padding: 15px; border-radius: 8px;">
                <div style="color: #666; font-size: 12px; text-transform: uppercase; margin-bottom: 5px;">Created At</div>
                <div style="color: #333; font-size: 16px; font-weight: 600;">
                    {{ $language->created_at->format('M d, Y h:i A') }}
                </div>
            </div>
            <div style="background: #f5f5f5; padding: 15px; border-radius: 8px;">
                <div style="color: #666; font-size: 12px; text-transform: uppercase; margin-bottom: 5px;">Last Updated</div>
                <div style="color: #333; font-size: 16px; font-weight: 600;">
                    {{ $language->updated_at->format('M d, Y h:i A') }}
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 20px;">
            <a href="{{ route('languages.edit', $language) }}" style="background: #848177; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Edit Language</a>
            <form action="{{ route('languages.destroy', $language) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this language?');">
                @csrf
                @method('DELETE')
                <button type="submit" style="background: #ef4444; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Delete Language</button>
            </form>
        </div>
    </div>
</x-app-layout>

