namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ManagerAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('manager_id')) {
            return redirect()->route('manager.login')->withErrors(['error' => 'Please login first']);
        }

        return $next($request);
    }
}