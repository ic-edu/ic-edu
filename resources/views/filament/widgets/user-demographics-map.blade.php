<x-filament-widgets::widget>
    <x-filament::section>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <div>
                <h2 style="font-size: 1rem; font-weight: 700; color: inherit; margin: 0;">User Demographics Map</h2>
                <p style="font-size: 0.75rem; color: #94a3b8; margin-top: 4px;">Geographic distribution based on IP Geolocation (auto-detected at login)</p>
            </div>
            <div style="display: flex; align-items: center; gap: 8px; font-size: 0.75rem; color: #64748b; font-weight: 600;">
                <span style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background: #3b82f6;"></span>
                {{ count($this->getLocations()) }} users mapped
            </div>
        </div>

        <iframe
            id="geo-map-frame"
            src="{{ route('admin.geo.map') }}"
            style="width: 100%; height: 430px; border: 1px solid #e2e8f0; border-radius: 12px; background: #f8fafc;"
            frameborder="0"
        ></iframe>

        {{-- Auto-refresh iframe every 5 minutes --}}
        <script>
            setInterval(function () {
                var frame = document.getElementById('geo-map-frame');
                if (frame) frame.src = frame.src;
            }, 30 * 1000); // refresh every 30 seconds
        </script>

        @if(count($this->getLocations()) === 0)
        <div style="margin-top: 12px; padding: 10px 14px; background: #fef9c3; border-radius: 8px; font-size: 0.78rem; color: #854d0e; font-weight: 600;">
            ⚡ No location data yet. Markers will appear when students log in for the first time.
        </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
