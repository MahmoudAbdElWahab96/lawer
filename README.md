# موقع المحامي — Landing Page + داشبورد

موقع تعريفي (Landing Page) لمكتب محاماة بلغتين (عربي RTL افتراضي + إنجليزي LTR)، مع داشبورد تحكم كامل بالعربية يدير كل محتوى الموقع بدون لمس أي كود، وSEO مهيأ من الأول.

> ⚖️ **الحالة الحالية**: البنية كاملة وشغالة (بيانات + داشبورد + SEO + مدونة). تصميم اللاندنج النهائي لسه هيتنفذ — الديزاين الحالي **placeholder** مؤقت بكل البيانات الحقيقية موصولة.

---

## التشغيل (على Lerd)

الموقع متصل على: **https://lawer.test**

```bash
lerd open              # يفتح الموقع في المتصفح
lerd php artisan ...   # أي أمر artisan من جوه بيئة Lerd
```

لو الموقع مش شغال أول مرة:

```bash
lerd start             # تشغيل Lerd نفسه
lerd env               # يظبط .env على خدمات Lerd (MySQL وغيره)
lerd db:create         # إنشاء قاعدة البيانات
lerd php artisan migrate:fresh --seed   # الجداول + البيانات التجريبية
npm run build          # الأصول (CSS/JS) — تعمل من الجهاز مباشرة
```

### بيانات الدخول للداشبورد

| | |
|---|---|
| الرابط | `https://lawer.test/admin` |
| الإيميل | `admin@lawyer.test` |
| الباسورد | `Lawyer#2026!Admin` |

**غيّرهم فورًا قبل التسليم للعميل:**

```bash
lerd php artisan tinker --execute="User::where('email','admin@lawyer.test')->update(['email'=>'الإيميل-الجديد','password'=>'الباسورد-الجديد'])"
```

---

## التقنيات

- **Laravel 13** + PHP 8.5
- **Filament 5** — لوحة التحكم (عربي RTL تلقائيًا)
- **Blade + Tailwind v4 + Alpine** — الواجهة (SSR كامل = SEO ممتاز)
- **MySQL 8.4** — خدمة Lerd المدمجة
- محتوى ثنائي اللغة عبر أعمدة JSON مع fallback تلقائي (اللغة الحالية → عربي → إنجليزي)

## هيكل الموقع العام

| المسار | الوصف |
|---|---|
| `/ar` | الرئيسية العربية (الافتراضية — `/` بيحوّل عليها) |
| `/en` | النسخة الإنجليزية |
| `/ar/blog` و `/en/blog` | المدونة باللغتين |
| `/sitemap.xml` | خريطة موقع ديناميكية لكل اللغات والمقالات |
| `/robots.txt` | متحكم فيه من الإعدادات (بيمنع فهرسة `/admin`) |

## الداشبورد — إيه اللي المحامي يقدر يتحكم فيه؟

كل ده من `/admin` بدون كود:

- **مجالات الممارسة** — إضافة/تعديل/حذف/ترتيب بالسحب (10 مزروعين حاليًا)
- **مميزات المكتب (لماذا تختارنا)** — زي المرجع mosaadlawyer.com
- **آراء العملاء** — بالتقييم النجمي
- **الأسئلة الشائعة** — بتتحول Schema للبحث
- **المقالات** — محرر نصوص + صورة غلاف + نشر/مسودة
- **رسائل الاستشارات** — الرسايل الجديدة بتيجي بعداد أحمر على القائمة، مع نوع الاستشارة وأزرار اتصال/واتساب مباشرة
- **إعدادات الموقع** — بيانات المحامي والواجهة/التواصل والسوشيال/الإحصائيات/رفع اللوجو والصور
- **إعدادات SEO** — العنوان والوصف لكل لغة + صورة المشاركة OG + كود Google Search Console + تشغيل/إيقاف الفهرسة

## SEO — المبني جوه

- Meta title/description لكل لغة + canonical
- `hreflang` كامل (ar / en / x-default) — يتبدل صح مع كل صفحة
- Open Graph + Twitter Cards بصورة مشاركة قابلة للرفع
- **JSON-LD Schemas**: `Attorney` (كل الصفحات) + `FAQPage` (الرئيسية) + `BlogPosting` (المقالات)
- sitemap.xml ديناميكي + robots.txt

## ملفات مهمة

```
app/Filament/                    ← كل ملفات لوحة التحكم
app/Filament/Pages/Settings.php  ← صفحة الإعدادات (بيانات + SEO)
app/Models/Concerns/HasLocalizedFields.php  ← دالة t() للحقول ثنائية اللغة
resources/views/home.blade.php   ← اللاندنج placeholder (هتتبدل بالتصميم النهائي)
resources/views/partials/seo.blade.php     ← كل الـ meta والـ JSON-LD
lang/ar|en/site.php              ← ترجمات الواجهة
database/seeders/                ← البيانات التجريبية القابلة للتعديل
gui-test-screenshots/            ← أدلة اختبار الجهاز (للحذف قبل النشر)
```

## لما التصميم النهائي يوصل

اللاندنج الحالية placeholder نظيفة بكل الداتا موصولة (`$settings`, `$practiceAreas`, `$features`, `$testimonials`, `$faqs`, `$articles`). تنفيذ التصميم = استبدال الـ markup في `home.blade.php` + الـ partials، والهوية اللونية من `resources/css/app.css` (متغيرات `--color-brand-*` و `--color-gold-*`). أي sections جديدة من المرجع بتتفضل تتحول لموديل + Resource زي ما عملنا مع «مميزاتنا».

## ملاحظات للنشر (Production)

- `APP_ENV=production` + `APP_DEBUG=false`
- `php artisan config:cache route:cache view:cache`
- فعّل HTTPS (كل اللينكات relative فمش هتتحتاج تعديل)
- رفع الصور بيروح `storage/app/public` — لازم `storage:link` على السيرفر
- عدّل قيم الإحصائيات والبيانات التجريبية من الداشبورد قبل الإطلاق
