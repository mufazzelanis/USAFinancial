<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class SiteSetting extends Model
{
    protected $fillable = ['group', 'key', 'value'];

    /**
     * In-memory only (never serialized/cached across requests) — reset automatically
     * every new request, and explicitly on save/delete within the same request.
     */
    protected static ?Collection $memoized = null;

    public static function get(string $key, ?string $default = null): ?string
    {
        $value = static::allCached()->firstWhere('key', $key)?->value;

        return filled($value) ? $value : $default;
    }

    /**
     * The full, correctly-formatted international WhatsApp number (country
     * dial code + local number, digits only, no leading 0) — ready to drop
     * straight into a wa.me link. Returns null if no local number is set.
     */
    public static function whatsappNumber(): ?string
    {
        $local = preg_replace('/\D+/', '', (string) static::get('whatsapp_number'));
        $local = ltrim($local, '0');

        if ($local === '') {
            return null;
        }

        $country = config('countries.'.static::get('whatsapp_country', 'BD'));

        return ($country['dial'] ?? '').$local;
    }

    public static function allCached(): Collection
    {
        return static::$memoized ??= static::query()->get(['id', 'group', 'key', 'value']);
    }

    protected static function booted(): void
    {
        static::saved(fn () => static::$memoized = null);
        static::deleted(fn () => static::$memoized = null);
    }
}
