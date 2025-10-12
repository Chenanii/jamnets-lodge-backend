<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\UserInvitationMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $perPage = $request->get('per_page', 10);

        $users = User::query()
            ->when($search, fn($query) =>
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%"))
            ->latest()
            ->paginate($perPage);

        return response()->json($users);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'nullable|string|max:50',
        ]);

        $token = Str::random(40);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'invitation_token' => $token,
            'is_invited' => true,
        ]);

        $frontendUrl = env('FRONTEND_URL', 'http://localhost:5173');
        $invitationLink = "{$frontendUrl}/create-account/{$token}";

        Mail::to($user->email)->queue(new UserInvitationMail($user, $invitationLink));


        return response()->json([
            'message' => 'User added and invitation email sent successfully!',
            'user' => $user
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$id}",
            'role' => 'nullable|string|max:50',
        ]);

        $user->update($request->only(['name', 'email', 'role']));

        return response()->json([
            'message' => 'User updated successfully!',
            'user' => $user
        ]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully!']);
    }

    public function setupAccount(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|min:9|confirmed',
        ]);

        $user = User::where('invitation_token', $request->token)->firstOrFail();

        $user->update([
            'password' => bcrypt($request->password),
            'invitation_token' => null,
            'is_invited' => false,
        ]);

        return response()->json(['message' => 'Account setup complete. You can now log in.']);
    }
}
