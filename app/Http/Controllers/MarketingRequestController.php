<?php

namespace App\Http\Controllers;

use App\Models\MarketingRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MarketingRequestController extends Controller
{
    // Public form
    public function create()
    {
        $types = [
            'apartment' => 'شقة',
            'villa' => 'فيلا',
            'land' => 'أرض',
            'office' => 'مكتب',
            'shop' => 'محل',
        ];
        return view('marketing.request', compact('types'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['nullable','string','max:120'],
            'email' => ['nullable','email','max:190'],
            'phone' => ['nullable','string','max:40'],
            'property_title' => ['nullable','string','max:190'],
            'city' => ['nullable','string','max:120'],
            'district' => ['nullable','string','max:120'],
            'type' => ['nullable','string','max:40'],
            'price' => ['nullable','integer'],
            'area' => ['nullable','integer'],
            'description' => ['nullable','string','max:5000'],
            'files.*' => ['nullable','file','max:8192'],
        ]);

        $mr = new MarketingRequest();
        $mr->fill($data);
        // Handle file uploads
        $paths = [];
        if ($request->hasFile('files')) {
            $dir = public_path('uploads/marketing');
            if (!is_dir($dir)) { @mkdir($dir, 0777, true); }
            foreach ((array)$request->file('files') as $i => $file) {
                if (!$file) continue;
                $ext = $file->getClientOriginalExtension();
                $name = 'mr_'.time().'_'.Str::random(6).'_'.$i.'.'.$ext;
                $file->move($dir, $name);
                $paths[] = '/uploads/marketing/'.$name;
            }
        }
        if (!empty($paths)) {
            $mr->files = $paths;
        }
        $mr->status = 'new';
        $mr->save();

        Log::info('Marketing request submitted', ['id' => $mr->id]);
        return redirect()->route('marketing.request.create')->with('ok', 'تم إرسال طلب التسويق بنجاح. سنقوم بالتواصل معك قريبًا.');
    }

    // Staff management
    public function index(Request $request)
    {
        $this->authorizeStaff();
        $q = MarketingRequest::query();
        if ($s = $request->input('status')) {
            $q->where('status', $s);
        }
        $items = $q->latest()->paginate(15)->withQueryString();
        return view('admin.marketing_requests.index', compact('items'));
    }

    public function show(MarketingRequest $marketingRequest)
    {
        $this->authorizeStaff();
        $employees = User::where('is_staff', true)->orderBy('name')->get();
        return view('admin.marketing_requests.show', [
            'mr' => $marketingRequest,
            'employees' => $employees,
        ]);
    }

    public function update(Request $request, MarketingRequest $marketingRequest)
    {
        $this->authorizeStaff();
        $data = $request->validate([
            'status' => ['required','string','max:30'],
            'assigned_employee_id' => ['nullable','integer','exists:users,id'],
        ]);
        $marketingRequest->status = $data['status'];
        $marketingRequest->assigned_employee_id = $data['assigned_employee_id'] ?? null;
        $marketingRequest->updated_by = auth()->id();
        $marketingRequest->save();
        return back()->with('ok', 'تم تحديث الحالة/التعيين');
    }

    private function authorizeStaff(): void
    {
        if (!auth()->check() || !(optional(auth()->user())->is_staff)) {
            abort(403);
        }
    }
}
