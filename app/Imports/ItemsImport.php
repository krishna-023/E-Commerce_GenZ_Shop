<?php

namespace App\Imports;

use App\Models\Item;
use App\Models\Category;
use App\Models\Contact;
use App\Models\OpeningTime;
use App\Models\SocialIcon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class ItemsImport implements ToCollection, WithHeadingRow, ShouldQueue, WithChunkReading
{
    /**
     * Handle each row from Excel
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            try {
                // ===== 1️⃣ Category =====
                $categoryId = $row['category_id'] ?? null;

                if (!empty($row['category_name'])) {
                    $category = Category::firstOrCreate(['Category_Name' => $row['category_name']]);
                    $categoryId = $category->id;
                }

                if (!empty($row['child_category_name'])) {
                    $childCategory = Category::firstOrCreate([
                        'Category_Name' => $row['child_category_name'],
                        'parent_id' => $categoryId
                    ]);
                    $categoryId = $childCategory->id;
                }

                // ===== 2️⃣ Main Item =====
                $item = Item::create([
                    'title' => $row['title'] ?? 'Untitled',
                    'subtitle' => $row['subtitle'] ?? null,
                    'content' => $row['content'] ?? null,
                    'item_featured' => $row['item_featured'] ?? 0,
                    'permalink' => $row['permalink'] ?? null,
                    'image' => $row['image'] ?? null,
                    'category_id' => $categoryId,
                    'author_username' => $row['author_username'] ?? null,
                    'author_email' => $row['author_email'] ?? null,
                    'author_first_name' => $row['author_first_name'] ?? null,
                    'author_last_name' => $row['author_last_name'] ?? null,
                    'slug' => $row['slug'] ?? null,
                    'parent' => $row['parent'] ?? null,
                    'parent_slug' => $row['parent_slug'] ?? null,
                ]);

                // ===== 3️⃣ Deserialize item data =====
                if (!empty($row['_ait_item_item_data'])) {
                    $itemData = @unserialize($row['_ait_item_item_data']);

                    if ($itemData && is_array($itemData)) {

                        // Contacts / Map
                        $item->contacts()->create([
                            'telephone' => $itemData['telephone'] ?? null,
                            'phone1' => $itemData['telephoneAdditional'] ?? null,
                            'phone2' => $itemData['phone2'] ?? null,
                            'email' => $itemData['email'] ?? null,
                            'contactOwnerBtn' => $itemData['contactOwnerBtn'] ?? 0,
                            'web' => $itemData['web'] ?? null,
                            'webLinkLabel' => $itemData['webLinkLabel'] ?? null,
                            'address' => $itemData['map']['address'] ?? null,
                            'latitude' => $itemData['map']['latitude'] ?? null,
                            'longitude' => $itemData['map']['longitude'] ?? null,
                            'streetview' => $itemData['map']['streetview'] ?? null,
                            'swheading' => $itemData['map']['swheading'] ?? null,
                            'swpitch' => $itemData['map']['swpitch'] ?? null,
                            'swzoom' => $itemData['map']['swzoom'] ?? null,
                        ]);

                        // Opening Hours
                        if (!empty($itemData['displayOpeningHours'])) {
                            $item->opening_Time()->create([
                                'display_opening_hours' => $itemData['displayOpeningHours'] ?? 0,
                                'openingHoursMonday' => $itemData['openingHoursMonday'] ?? null,
                                'openingHoursTuesday' => $itemData['openingHoursTuesday'] ?? null,
                                'openingHoursWednesday' => $itemData['openingHoursWednesday'] ?? null,
                                'openingHoursThursday' => $itemData['openingHoursThursday'] ?? null,
                                'openingHoursFriday' => $itemData['openingHoursFriday'] ?? null,
                                'openingHoursSaturday' => $itemData['openingHoursSaturday'] ?? null,
                                'openingHoursSunday' => $itemData['openingHoursSunday'] ?? null,
                                'openingHoursNote' => $itemData['openingHoursNote'] ?? null,
                            ]);
                        }

                        // Social Icons
                        if (!empty($itemData['socialIcons'])) {
                            SocialIcon::create([
                                'item_id' => $item->id,
                                'displaySocialIcons' => $itemData['displaySocialIcons'] ?? 1,
                                'openInNewWindow' => $itemData['socialIconsOpenInNewWindow'] ?? 1,
                                'socialIcons' => $itemData['socialIcons'] ?? null,
                                'socialIcons_url' => $itemData['socialIcons_url'] ?? null,
                            ]);
                        }

                        // TODO: Handle galleries / features if needed
                    }
                }

            } catch (\Exception $e) {
                Log::error("Excel import row failed: " . $e->getMessage());
                continue;
            }

        } // end foreach row
    }

    /**
     * Number of rows per chunk for queue
     */
    public function chunkSize(): int
    {
        return 50; // Adjust per your server memory
    }
}
