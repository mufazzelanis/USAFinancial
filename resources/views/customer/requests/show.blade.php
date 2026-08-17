<x-customer-layout title="Request Details">
    <div class="mx-auto max-w-2xl">
        <a href="{{ route('customer.requests.index') }}" class="mb-4 inline-flex items-center gap-1 text-sm font-semibold text-slate-500 hover:text-navy-900">&larr; Back to requests</a>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <h2 class="text-xl font-extrabold text-navy-900">{{ $serviceRequest->title }}</h2>
                    <p class="mt-1 text-sm text-slate-500">{{ \App\Models\ServiceRequest::types()[$serviceRequest->type] ?? $serviceRequest->type }} · Submitted {{ $serviceRequest->created_at->format('d M Y') }}</p>
                </div>
                <x-status-badge :status="$serviceRequest->status" />
            </div>

            <div class="mt-6 border-t border-slate-100 pt-6">
                <p class="text-xs font-bold uppercase tracking-wide text-slate-400">Details</p>
                <p class="mt-2 whitespace-pre-line text-sm text-slate-600">{{ $serviceRequest->description ?: 'No additional details provided.' }}</p>
            </div>

            <div class="mt-6 grid grid-cols-2 gap-4 border-t border-slate-100 pt-6 text-sm">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wide text-slate-400">Priority</p>
                    <p class="mt-1 font-semibold capitalize text-navy-900">{{ $serviceRequest->priority }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-wide text-slate-400">Last Updated</p>
                    <p class="mt-1 font-semibold text-navy-900">{{ $serviceRequest->updated_at->diffForHumans() }}</p>
                </div>
            </div>
        </div>
    </div>
</x-customer-layout>
