public function up(): void
{
    Schema::create('posts', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('slug')->unique();
        $table->text('content');
        $table->string('image')->nullable();
        $table->string('category')->nullable();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->boolean('is_published')->default(false);
        $table->timestamps();
    });
}
