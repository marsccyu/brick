<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            // region s1
            [1, 1, "認識積木", "", "認識零件"],
            [1, 2, "伸縮夾鉗", "", "交叉連桿"],
            [1, 3, "戰鬥陀螺", "", "重心、齒輪比"],
            [1, 4, "平衡老鷹", "", "重心、配重"],
            [1, 5, "軌道車", "", "重力"],
            [1, 6, "起重機", "", "滑輪組"],
            [1, 7, "旋轉飛機", "", "離心力"],
            [1, 8, "風帆車", "", "風力"],
            [1, 9, "纜車", "", "滑輪"],
            [1, 10, "走鋼索的人", "", "滑輪"],
            [1, 11, "積木槍", "", "彈力"],
            [1, 12, "圓盤推推", "", "彈力"],
            [1, 13, "迴力車", "", "彈力"],
            [1, 14, "鱷魚拔牙", "", "棘輪裝置"],
            [1, 15, "慣性車", "", "慣性定律"],
            [1, 16, "小小神射手", "", "團隊競賽"],
            // endregion
            // region s2
            [2, 1, "投石器", "", "槓桿原理"],
            [2, 2, "投石車", "", "側向卡榫"],
            [2, 3, "小雞啄米", "", "向心力"],
            [2, 4, "瑞利球", "", "逆流而上"],
            [2, 5, "旋轉椅凳", "", "蝸桿應用"],
            [2, 6, "攪拌器", "", "傘型齒"],
            [2, 7, "十字弓", "", "尺條應用"],
            [2, 8, "升降台", "", "尺條應用"],
            [2, 9, "彈射大砲", "", "槓桿原理、彈力"],
            [2, 10, "風車", "", "認識馬達"],
            [2, 11, "衝鋒賽車", "", "馬達應用"],
            [2, 12, "電動釣竿", "", "馬達、定滑輪"],
            [2, 13, "爬升纜車", "", "馬達、尺條"],
            [2, 14, "陀螺發射器", "", "彈跳裝置"],
            [2, 15, "坦克車", "", "馬達、鍊條與鍊輪"],
            [2, 16, "城堡攻防戰", "", "團隊競賽"],
            // endregion
            // region s3
            [3, 1, "自動投石車", "", "馬達、卡榫"],
            [3, 2, "自動門", "", "雙向開啟機構"],
            [3, 3, "視覺暫留", "", "齒輪比、視覺原理"],
            [3, 4, "移動箭靶", "", "往復機構"],
            [3, 5, "塔式吊車", "", "滑輪組"],
            [3, 6, "自動機構", "", "往復機構、紙藝"],
            [3, 7, "變速箱", "", "齒輪比轉換"],
            [3, 8, "折返碰碰車", "", "撞擊開關"],
            [3, 9, "小企鵝", "", "仿生獸設計"],
            [3, 10, "暴力甲蟲", "", "連桿設計"],
            [3, 11, "大鵬展翅", "", "雙向旋轉機構"],
            [3, 12, "拉繩猴子", "", "拉繩仿生獸"],
            [3, 13, "減速軌道", "", "機關原理與實作"],
            [3, 14, "步步高升", "", "機關原理與實作"],
            [3, 15, "升旗裝置", "", "機關原理與實作"],
            [3, 16, "機關整合", "", "機關原理與實作"],
            // endregion
            // region s4
            [4, 1,	'轉向軌道', "", '機關原理與實作'],
            [4, 2,	'側向卡榫', "", '機關原理與實作'],
            [4, 3,	'骨牌效應', "", '機關原理與實作'],
            [4, 4,	'連續纜車', "", '機關原理與實作'],
            [4, 5,	'升降旗裝置', "", '機關原理與實作'],
            [4, 6,	'連續彈射', "", '機關原理與實作'],
            [4, 7,	'分歧軌道', "", '機關原理與實作'],
            [4, 8,	'按壓式步進機關', "", '機關原理與實作'],
            [4, 9,	'連續釋放裝置', "", '機關原理與實作'],
            [4, 10,	'發射火箭', "", '機關原理與實作'],
            [4, 11,	'重捶機關', "", '機關原理與實作'],
            [4, 12,	'水槍', "", '認識氣壓水動'],
            [4, 13,	'灑水器', "", '認識壓力'],
            [4, 14,	'水箭車', "", '作用力與反作用力'],
            [4, 15,	'液壓手臂', "", '帕斯卡原理'],
            [4, 16,	'液壓機關', "", '機關串聯、液壓'],
            // endregion
            // region s5
            [5, 1, '認識Micro:bit', "","1. 基本操作,2. 設計視窗,3. 主要功能,4.	積木種類"],
            [5, 2, '心動99', "","1.	屬性、事件、方法, 2.LED積木、迴圈設計,3. 按鈕使用"],
            [5, 3, '程式音樂家', "","1. 音階積木,2. 數位腳位原理,3.鱷魚夾使用"],
            [5, 4, '智慧風車', "","1. Micro:bit溫感器原理,2. 外接馬達,3. 邏輯積木"],
            [5, 5, '指南針', "","1.	Micro:bit指南針原理,2. 認識方位與角度,3. 邏輯積木(IF、OR)"],
            [5, 6, '光線魔術師', "","1.	Micro:bit光感原理,2.	燈位座標概念"],
            [5, 7, '抗震測試', "","1. Micro:bit加速度感應, 2.	數學積木"],
            [5, 8, '剪刀石頭步', "","1.	布林運算,2.	陣列積木,3.	廣播功能"],
            [5, 9, '金屬探測器', "","1.	Micro:bit磁力感應功能,2.	尋找身邊的金屬"],
            [5, 10, '紅綠燈', "","1. 紅綠燈邏輯拆解,2. 外接燈號"],
            [5, 11, '測距輪', "","1. 記數邏輯, 2. 測距輪實際操作"],
            [5, 12, '齒輪傳動', "","1.	馬達積木,2.	齒輪比"],
            [5, 13, '四輪傳動車', "","1. 車體設計,2. 馬達控制"],
            [5, 14, '貨車',"","1. 轉向機構設計"],
            [5, 15, '螺旋槳飛機', "","1. 皮帶輪應用, 2. 正反轉設計"],
            [5, 16, '自轉直升機', "","1. 尺條應用,2.	升降機構"],
            // endregion
            // region s6
            [6, 1 , "平交道", "",  "平交道柵門設計、感應與燈號程式"],
            [6, 2 , "平交道", "",  "平交道柵門設計、感應與燈號程式"],
            [6, 3, "吊車", "", "吊臂設計與車體配重, 馬達設置與程式"],
            [6, 4, "吊車", "", "吊臂設計與車體配重, 馬達設置與程式"],
            [6, 5, "循跡自走車", "", "循跡車體設計, 循跡感應程式"],
            [6, 6, "循跡自走車", "", "循跡車體設計, 循跡感應程式"],
            [6, 7, "智慧避障車", "", "避障車體設計, 避障程式"],
            [6, 8, "智慧避障車", "", "避障車體設計, 避障程式"],
            [6, 9, "自動揮棒", "", "揮棒機構設計, 遠距感應廣播程式"],
            [6, 10, "自動揮棒", "", "揮棒機構設計, 遠距感應廣播程式"],
            [6, 11, "電腦繪圖", "", "連桿繪圖機構設計, 電腦繪圖程式設計"],
            [6, 12, "電腦繪圖", "", "連桿繪圖機構設計, 電腦繪圖程式設計"],
            [6, 13, "體感貪吃蛇", "", "貪吃蛇程式設計, 計分對戰程式設計"],
            [6, 14, "體感貪吃蛇", "", "貪吃蛇程式設計, 計分對戰程式設計"],
            [6, 15, "三軸機械手臂", "", "機械手臂機構設計, 三軸控制程式設計"],
            [6, 16, "三軸機械手臂", "", "機械手臂機構設計, 三軸控制程式設計"],
            // endregion
        ];

        $mapping = ['course_id', "lesson_num", "title", "subtitle", "content"];

        $default_data = [];
        foreach ($data as $list)
        {
            foreach ($list as $key => $value)
            {
                $temp[$mapping[$key]] = $value;
                $temp['created_at'] = date('Y-m-d H:i:s');
                $temp['updated_at'] = date('Y-m-d H:i:s');
            }
            $default_data[] = $temp;
        }

        DB::table('lessons')->insert($default_data);
    }
}
