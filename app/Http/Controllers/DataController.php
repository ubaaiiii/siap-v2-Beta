<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use DataTables;
use DateTime;
use Validator;
use Carbon\Carbon;
use GuzzleHttp\Promise\Each;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use Session;
class DataController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  // public function __construct()
  // {
  //     $this->middleware('auth');
  // }
  public function __construct()
  {
    $this->middleware('cek:admin');
  }
  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {
    
  }
  public function generateQuery($request, $table, $columns, $select) {
    DB::enableQueryLog();

    $table->select($select);
    $awal = $table->get()->count();
    $sql[] = Str::replaceArray('?', $table->getBindings(), $table->toSql());

    if (!empty($request->search)) {
      $table->where(function ($query) use ($columns, $request) {
        for ($i = 0; $i < count($columns); $i++) {
          if ($i == 0) {
            $query->where($columns[$i], 'like', '%' . $request->search . '%');
          } else {
            $query->orWhere($columns[$i], 'like', '%' . $request->search . '%');
          }
        }
      });
    }

    if (!empty($request->order) && $request->has('order')) {
      for ($i = 0; $i < count($request->order); $i++) {
        $table->orderBy($columns[$request->order[$i]['column']], $request->order[$i]['dir']);
      }
    }

    $all_record = $table->get()->count();
    $sql[] = Str::replaceArray('?', $table->getBindings(), $table->toSql());

    if (!empty($request->start)) {
      $table->skip($request->start);
    }

    if (!empty($request->length)) {
      $table->take($request->length);
    }
    $result = $table->get();
    $sql[] = Str::replaceArray('?', $table->getBindings(), $table->toSql());
    // return DB::getQueryLog();
    // $sql = Str::replaceArray('?', $table->getBindings(), $table->toSql());
    $i = 0;
    // foreach(DB::getQueryLog() as $query) {
    //   $sql[] = Str::replaceArray('?', $query['bindings'], $query->toSql());
    //   // $sql[] = $query;
    // }
    return [$result, $awal, $all_record, $sql];
        // return response()->json([
        //     "draw"              => 1,
        //     "recordsTotal"      => $awal,
        //     "recordsFiltered"   => $result->count(),
        //     "data"              => (object) $result,
        // ], 200);
  }
}
