<?php
namespace App\Http\Controllers;
use App\Models\Table;
use Illuminate\Http\Request;
use App\Http\Resources\TableResource;
use App\Models\Category;
use App\Services\ConfChanger;
use Inertia\Inertia;


class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $grocery = auth()->user()->grocery;
   
      $tables = TableResource::collection($grocery->tables);      
      
      return inertia('Table/Index', compact('tables'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {            
      $request->validate([
        'name' => ['required', 'string'],
        'number' => ['required']
      ]);
      $table = Table::create([
        'name' => $request->name,     
        'number' => $request->number,
        'grocery_id' => auth()->user()->grocery->id
      ]);      
      return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Table  $area
     * @return \Illuminate\Http\Response
     */
    public function show(Table $table)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Table  $area
     * @return \Illuminate\Http\Response
     */
    public function edit(Table $table)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Table $table)
    {
      
      $request->validate([
        'name' => ['required', 'string'],
        'number' => ['required']
      ]);

      $table->update([
        'name' => $request->name,
        'number' => $request->number,
        'grocery_id' => auth()->user()->grocery->id
      ]);
      
      return back();
    }

    /**
     * Remove the specified resource from storage.
     *     
     * @return \Illuminate\Http\Response
     */
    public function destroy(Table $table)
    {
      $table->delete();
      return back();
    }

    private function formatprice($price)
    {
      $formatArray = explode(".", $price);
      if (sizeof($formatArray) > 1) {
        $formatArray[0] = (int)$formatArray[0].'00';
        $formattedPrice = (int)$formatArray[0] + (int)$formatArray[1];
        return $formattedPrice;

      } else {
        $formattedPrice = $formatArray[0].'00';
        return (int)$formattedPrice;
      }
    }

    public function qrcode(Table $table)
    {         
      $app_url = parse_url(config('app.url'))["host"];
      $domain = request()->getHost();
      if (str_contains($app_url, $domain)) {
        $url = config('app.url') . '/grocerys/' . $table->grocery->slug . '?tid=' . $table->id;        
      } else {
        $url = request()->getHttpHost() . '/grocerys/' . $table->grocery->slug . '?tid=' . $table->id;
      }
      // $vendorUrl = substr_count(str_replace('www.', '', $_SERVER['HTTP_HOST']), '.') > 1 ? substr(str_replace('www.', '', $_SERVER['HTTP_HOST']), 0, strpos(str_replace('www.', '', $_SERVER['HTTP_HOST']), '.')) : '';      
      $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=512x512&format=png&data=' . $url;      
      
      $tempImage = tempnam(sys_get_temp_dir(), 'qr.png');
      @copy($qrUrl, $tempImage);                  
      return response()->download($tempImage, 'qr.png',array('Content-Type:image/png'));
    }

}