<div dir="rtl" class="space-y-4">
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">الاسم</p>
            <p class="text-base font-semibold">{{ $record->name }}</p>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">رقم الهاتف</p>
            <a href="tel:{{ $record->phone }}" class="text-base font-semibold text-primary-600 dark:text-primary-400" dir="ltr">{{ $record->phone }}</a>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">البريد الإلكتروني</p>
            @if ($record->email)
                <a href="mailto:{{ $record->email }}" class="text-base font-semibold text-primary-600 dark:text-primary-400" dir="ltr">{{ $record->email }}</a>
            @else
                <p class="text-base text-gray-400">غير متوفر</p>
            @endif
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">تاريخ الإرسال</p>
            <p class="text-base font-semibold">{{ $record->created_at->format('Y/m/d h:i A') }}</p>
        </div>
        <div class="sm:col-span-2">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">نوع الاستشارة</p>
            <p class="text-base font-semibold">{{ $record->practiceArea?->t('name') ?? 'غير محدد' }}</p>
        </div>
    </div>

    <div>
        <p class="mb-2 text-sm font-medium text-gray-500 dark:text-gray-400">نص الرسالة</p>
        <div class="rounded-xl bg-gray-50 p-4 text-base leading-relaxed whitespace-pre-line dark:bg-gray-900">{{ $record->message }}</div>
    </div>

    <div class="flex gap-2">
        <a href="tel:{{ $record->phone }}"
           class="fi-btn fi-btn-size-md fi-btn-color-primary flex items-center gap-2 rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white">
            اتصال
        </a>
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $record->phone) }}" target="_blank" rel="noopener"
           class="fi-btn flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white">
            واتساب
        </a>
    </div>
</div>
