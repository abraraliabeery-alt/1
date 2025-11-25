<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Client,Tender,BoqHeader,BoqItem,PreviousProject};

class TenderDemoSeeder extends Seeder
{
    public function run(): void
    {
        $client = Client::firstOrCreate(['name'=>'غرفة الرياض'], [
            'sector'=>'غرفة تجارية','city'=>'الرياض','contact_ref'=>'قسم المشتريات'
        ]);

        $tender = Tender::create([
            'title' => 'توريد أجهزة حاسب وملحقاتها',
            'tender_no' => '39',
            'client_id' => $client->id,
            'client_name' => $client->name,
            'competition_no' => '39',
            'submission_date' => now()->setDate(2025,10,15),
            'validity_days' => 90,
            'notes' => 'عينة تجريبية لعرض المنصة',
            'status' => 'draft',
            'created_by' => 1,
            'cover_image_url' => 'https://images.unsplash.com/photo-1518779578993-ec3579fee39f?q=80&w=1600&auto=format&fit=crop',
        ]);

        $header = BoqHeader::create([
            'tender_id'=>$tender->id,
            'currency'=>'SAR',
            'version_no'=>1,
            'is_current'=>true,
        ]);

        $items = [
            ['item_name'=>'قرص تخزين SSD 1TB','unit'=>'قطعة','quantity'=>10,'unit_price'=>350.00],
            ['item_name'=>'كيبل HDMI 2.1','unit'=>'قطعة','quantity'=>25,'unit_price'=>45.00],
            ['item_name'=>'حاسب مكتبي i5/16GB/512GB','unit'=>'جهاز','quantity'=>8,'unit_price'=>2850.00],
            ['item_name'=>'شاشة 27 بوصة FHD','unit'=>'شاشة','quantity'=>8,'unit_price'=>650.00],
        ];
        $order=1; $totalBefore = 0;
        foreach ($items as $row) {
            $line = ($row['quantity'] ?? 0) * ($row['unit_price'] ?? 0);
            $totalBefore += $line;
            BoqItem::create([
                'boq_id'=>$header->id,
                'item_name'=>$row['item_name'],
                'unit'=>$row['unit'],
                'quantity'=>$row['quantity'],
                'unit_price'=>$row['unit_price'],
                'total_line'=>$line,
                'sort_order'=>$order++,
            ]);
        }
        $vat = round($totalBefore * 0.15, 2);
        $tender->update([
            'total_before_vat'=>$totalBefore,
            'vat_amount'=>$vat,
            'total_with_vat'=>$totalBefore + $vat,
        ]);

        // previous projects sample
        for ($i=1;$i<=6;$i++) {
            PreviousProject::create([
                'tender_id'=>$tender->id,
                'project_name'=>"مشروع توريد ${i}",
                'client_name'=>'جهة حكومية',
                'year'=>2020 + ($i%5),
                'team_members'=>5+$i,
                'cost'=>25000 + $i*10000,
                'description'=>'أعمال توريد وتنفيذ بمواصفات قياسية',
            ]);
        }
    }
}
