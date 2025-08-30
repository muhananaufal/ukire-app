<x-app-layout>
    <div class="bg-gray-50 py-12 sm:py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-3xl space-y-8">

            <div>
                @include('profile.partials.update-profile-information-form')
            </div>

            <div>
                @include('profile.partials.update-password-form')
            </div>

            <div>
                @include('profile.partials.delete-user-form')
            </div>

        </div>
    </div>
</x-app-layout>
