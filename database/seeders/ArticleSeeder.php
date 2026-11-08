<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'slug' => 'custody-rights-in-egypt',
                'title' => [
                    'ar' => 'حق الحضانة في القانون المصري: دليل عملي للأمهات والآباء',
                    'en' => 'Custody Rights in Egyptian Law: A Practical Guide for Mothers and Fathers',
                ],
                'excerpt' => [
                    'ar' => 'متى تسقط الحضانة؟ ومن أولى بحضانة الطفل بعد الأم؟ دليل مبسط يشرح المواعيد والسنادات والقواعد التي تحكم حضانة الأبناء في مصر.',
                    'en' => 'When is custody forfeited? Who is entitled to the child after the mother? A simplified guide to the timelines and rules governing child custody in Egypt.',
                ],
                'body' => [
                    'ar' => "تنظم أحكام الحضانة في مصر مواد قانون الأحوال الشخصية رقم 25 لسنة 1929 وما بعده من تعديلات، وأبرز ما يهم الأب والأم:\n\n**أولًا: ترتيب أصحاب الحضانة**: الأم ثم الأمهات الأعلى درجة، ثم الخالات والأعمام بحسب الترتيب الذي حدده القانون. بقاء الطفل مع أمه هو الأصل ما لم يسقط حقها لأحد الأسباب القانونية كالزواج من أجنبي عن الطفل أو إهمال رعايته.\n\n**ثانيًا: سن انتهاء الحضانة**: تنتهي حضانة الصبي ببلوغه الخامسة عشرة، وحضانة البنت بزواجها أو بلوغها الخامسة عشرة ويُخيَّر بعدها المحضون فيمن يقيم معه، على أن يراعي القاضي مصلحة المحضون فوق كل اعتبار.\n\n**ثالثًا: الأجرة والحضانة**: لأم الطفل أجرة حضانة وأجر رضاعة إن كانت عاملة أو غير عاملة، وهي تختلف عن نفقة الطفل التي تجب على الأب.\n\n**رابعًا: رؤية المحضون**: من حُرم من الحضانة له حق رؤية الطفل في مواعيد منتظمة، ومن يمنع الرؤية دون مسوغ تعرض لجزاءات قانونية قد تصل لتغريمه.\n\nالخلاصة: ملفات الحضانة حساسة ومرتبطة بإجراءات ومواعيد دقيقة، وأي تأخير في اتخاذ الإجراء الصحيح قد يضر بموقفك. الاستشارة المبكرة توفر شهورًا من التقاضي.",
                    'en' => "Custody in Egypt is governed by the Personal Status Law No. 25 of 1929 and its amendments. The essentials every mother and father should know:\n\n**1. Order of custodians**: The mother first, then maternal grandmothers, then aunts and uncles per the statutory order. The child remaining with the mother is the default unless her right is forfeited for a legal reason, such as marrying someone unrelated to the child or neglecting care.\n\n**2. Age of custody end**: A boy's custody ends at fifteen; a girl's upon marriage or reaching fifteen, after which the child chooses whom to live with, with the judge weighing the child's best interest above all.\n\n**3. Custody fees**: The mother is entitled to a custody fee and nursing wage whether employed or not, separate from the child's maintenance owed by the father.\n\n**4. Visitation**: Whoever is denied custody retains a regular visitation right; obstructing visitation without cause invites legal penalties including fines.\n\nBottom line: custody files are sensitive and bound by strict procedure and deadlines: an early consultation can save months of litigation.",
                ],
                'published_at' => now()->subDays(10),
            ],
            [
                'slug' => 'wrongful-termination-guide',
                'title' => [
                    'ar' => 'الفصل التعسفي: ما هي حقوقك كمقاول أو موظف؟',
                    'en' => 'Wrongful Termination: What Are Your Rights as a Contractor or Employee?',
                ],
                'excerpt' => [
                    'ar' => 'دليل خطوة بخطوة: مدة تقديم الدعوى العمالية، ما الذي يُعد فصلًا تعسفيًا، وكيف تحسب تعويضك وفق قانون العمل المصري.',
                    'en' => 'A step-by-step guide: filing deadlines for labor claims, what counts as arbitrary dismissal, and how your compensation is calculated under Egyptian labor law.',
                ],
                'body' => [
                    'ar' => "قانون العمل المصري رقم 12 لسنة 2003: وتعديلاته اللاحقة: يمنح العامل شبكة حماية كاملة عند إنهاء العلاقة التعاقدية:\n\n**ما هو الفصل التعسفي؟**: إذا أنهى صاحب العمل العقد لسبب غير مشروع (كالانتقام من شكوى عمالية أو رفض العمل الإضافي القسري) يحق للعامل دعوى تعويض.\n\n**مواعيد مهمة**: الدعوى العمالية تسقط بعد سنة من تاريخ انتهاء العلاقة العمالية، ولذلك لا تأجيل في اتخاذ الإجراء.\n\n**حساب التعويض**: تراعي المحكمة مقدار الضرر ومدة الخدمة وظروف الطرفين، ولا يجوز أن يقل التعويض عن أجر شهرين عن كل سنة خدمة في حالة ثبوت الفصل التعسفي في بعض الحالات، إضافة لمستحقات نهاية الخدمة كاملة.\n\n**الإيجابيات القضائية**: الدعاوى العمالية معفاة من الرسوم أمام لجان فض المنازعات العمالية، وهي مرحلة إلزامية سابقة على المحكمة.\n\nنصيحة عملية: اجمع عقودك وإيصالات المرتب وأي مراسلات كتابية قبل الاستشارة: هذه المستندات تحسم قوة ملفك.",
                    'en' => "Egyptian Labor Law No. 12 of 2003: and its later amendments: grants employees a full protection net when the contractual relationship ends:\n\n**What is arbitrary dismissal?**: If the employer terminates the contract for an illegitimate reason (e.g., retaliation for a labor complaint), the employee may claim compensation.\n\n**Key deadlines**: A labor claim lapses one year after the employment relationship ends, so act without delay.\n\n**Compensation calculation**: The court weighs the harm, length of service, and both parties' circumstances; compensation cannot fall below two months' wages per year of service in certain confirmed cases, in addition to full end-of-service dues.\n\n**Procedural advantage**: Labor claims are exempt from fees before the labor dispute settlement committees, a mandatory stage before court.\n\nPractical tip: gather your contract, salary receipts, and any written correspondence before consulting: these documents decide the strength of your file.",
                ],
                'published_at' => now()->subDays(21),
            ],
            [
                'slug' => 'commercial-contract-checklist',
                'title' => [
                    'ar' => '7 بنود لا يجب أن تغيب عن أي عقد تجاري',
                    'en' => '7 Clauses No Commercial Contract Should Lack',
                ],
                'excerpt' => [
                    'ar' => 'من شرط التحكيم إلى غرامة التأخير: قائمة عملية بالبنود التي تحمي شركتك وتغلق أبواب النزاعات قبل أن تبدأ.',
                    'en' => 'From arbitration clauses to delay penalties: a practical checklist of the clauses that protect your company and close dispute doors before they open.',
                ],
                'body' => [
                    'ar' => "معظم النزاعات التجارية التي تصلنا كان سببها عقد مكتوب على عجل. قبل التوقيع على أي عقد تجاري، تأكد من وجود هذه البنود السبعة:\n\n**1. تعريف دقيق للأطراف والصفة**: الاسم القانوني الكامل وسجل تجاري وصفة الموقع (مدير بشركة توصية ليس كالشريك المتضامن).\n\n**2. نطاق العمل والمواصفات**: وصف تفصيلي للمقابل لا يترك مجالًا للاجتهاد.\n\n**3. المقابل المالي وطريقة السداد**: عملة السداد، جدول الدفعات، وشرط تعديل الأسعار إن طالت مدة التنفيذ.\n\n**4. غرامة التأخير**: نسبة محددة يومية أو شهرية بحد أقصى، حتى لا تتحول لغرامة مبالغ فيها يسقطها القضاء.\n\n**5. شرط القوة القاهرة**: تعريف واضح لما يُعد قوة قاهرة وأثرها على الالتزامات.\n\n**6. القانون الواجب التطبيق وشرط التحكيم**: تحديد جهة الفصل في النزاع مقدمًا يوفر سنتين من التقاضي المحلي.\n\n**7. الإخطارات والعنوان المختار**: عنوان رسمي للمراسلات يُعد التسليم إليه إنذارًا صحيحًا.\n\nمراجعة قانونية للعقد قبل التوقيع لا تستهلك ساعة واحدة، وقد توفر عليك معركة قضائية كاملة.",
                    'en' => "Most commercial disputes we receive stem from hastily drafted contracts. Before signing any commercial contract, verify these seven clauses:\n\n**1. Precise party definitions**: Full legal names, commercial registrations, and signing capacity.\n\n**2. Scope and specifications**: A detailed description leaving no room for interpretation.\n\n**3. Consideration and payment**: Currency, payment schedule, and price-adjustment terms for long executions.\n\n**4. Delay penalty**: A defined daily or monthly rate with a cap, avoiding penalties courts may strike down.\n\n**5. Force majeure**: A clear definition of what qualifies and its effect on obligations.\n\n**6. Governing law and arbitration**: Pre-agreeing the dispute forum saves years of local litigation.\n\n**7. Notices and elected address**: An official address where delivery counts as valid notice.\n\nA legal review before signature takes an hour; it may spare you an entire court battle.",
                ],
                'published_at' => now()->subDays(35),
            ],
        ];

        foreach ($items as $item) {
            Article::query()->updateOrCreate(
                ['slug' => $item['slug']],
                $item + ['is_published' => true],
            );
        }
    }
}
