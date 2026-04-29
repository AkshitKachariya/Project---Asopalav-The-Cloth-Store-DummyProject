<?php
include('./db_con.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Size Guide | Asopalav.in</title>
    <link rel="shortcut icon" href="./images/asopalav favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="./src/output.css" />
    <link rel="stylesheet" href="./css/all.css" />
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
            height: 5px;
            display: block;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #e5e7eb;
            border-radius: 5px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #c28e5c;
            border-radius: 5px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #374151;
        }

        /* Ensure table cells wrap text and prevent overflow */
        .table-cell {
            white-space: nowrap;
            min-width: 100px;
        }
    </style>
</head>

<body>

    <header class="sticky top-0 z-10 shadow bg-white">
        <?php include('./main_header.php'); ?>
    </header>

    <main class="py-15 lg:px-15 px-7 space-y-4">
        <div class="text-center text-3xl font-bold uppercase">Size Guide</div>
        <br>
        <div class="space-y-14">

            <section>
                <h2 class="text-lg font-bold mb-3 text-gray-800">Saree (in inches)</h2>
                <div class="overflow-x-auto custom-scrollbar rounded-xl shadow-lg bg-white border-1 border-[#c28e5c]">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-[#c28e5c] text-white text-sm uppercase tracking-wide">
                            <tr>
                                <th class="p-2 table-cell border-b border-[#c28e5c]   ">Size</th>
                                <th class="p-2 table-cell border-b border-[#c28e5c]">Bust</th>
                                <th class="p-2 table-cell border-b border-[#c28e5c]">Lower Bust</th>
                                <th class="p-2 table-cell border-b border-[#c28e5c]">Petticoat Waist</th>
                                <th class="p-2 table-cell border-b border-[#c28e5c]   ">Petticoat Length</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm">
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="p-2 table-cell border-b border-gray-200">32-XS</td>
                                <td class="p-2 table-cell border-b border-gray-200">32</td>
                                <td class="p-2 table-cell border-b border-gray-200">28</td>
                                <td class="p-2 table-cell border-b border-gray-200">32</td>
                                <td class="p-2 table-cell border-b border-gray-200">38</td>
                            </tr>
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="p-2 table-cell border-b border-gray-200">34-S</td>
                                <td class="p-2 table-cell border-b border-gray-200">34</td>
                                <td class="p-2 table-cell border-b border-gray-200">30</td>
                                <td class="p-2 table-cell border-b border-gray-200">34</td>
                                <td class="p-2 table-cell border-b border-gray-200">39</td>
                            </tr>
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="p-2 table-cell border-b border-gray-200">36-M</td>
                                <td class="p-2 table-cell border-b border-gray-200">36</td>
                                <td class="p-2 table-cell border-b border-gray-200">32</td>
                                <td class="p-2 table-cell border-b border-gray-200">36</td>
                                <td class="p-2 table-cell border-b border-gray-200">40</td>
                            </tr>
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="p-2 table-cell border-b border-gray-200">38-L</td>
                                <td class="p-2 table-cell border-b border-gray-200">38</td>
                                <td class="p-2 table-cell border-b border-gray-200">34</td>
                                <td class="p-2 table-cell border-b border-gray-200">38</td>
                                <td class="p-2 table-cell border-b border-gray-200">40</td>
                            </tr>
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="p-2 table-cell border-b border-gray-200">40-XL</td>
                                <td class="p-2 table-cell border-b border-gray-200">40</td>
                                <td class="p-2 table-cell border-b border-gray-200">36</td>
                                <td class="p-2 table-cell border-b border-gray-200">40</td>
                                <td class="p-2 table-cell border-b border-gray-200">40</td>
                            </tr>
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="p-2 table-cell">42-XXL</td>
                                <td class="p-2 table-cell">42</td>
                                <td class="p-2 table-cell">38</td>
                                <td class="p-2 table-cell">42</td>
                                <td class="p-2 table-cell">42</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section>
                <h2 class="text-lg font-bold mb-3 text-gray-800">Salwar Suit (in inches)</h2>
                <div class="overflow-x-auto custom-scrollbar rounded-xl shadow-lg bg-white border-1 border-[#c28e5c]">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-[#c28e5c] text-white text-sm uppercase tracking-wide">
                            <tr>
                                <th class="p-2 table-cell border-b border-[#c28e5c]   ">Size</th>
                                <th class="p-2 table-cell border-b border-[#c28e5c]">Bust</th>
                                <th class="p-2 table-cell border-b border-[#c28e5c]">Lower Bust</th>
                                <th class="p-2 table-cell border-b border-[#c28e5c]">Armhole</th>
                                <th class="p-2 table-cell border-b border-[#c28e5c]">Bottom Waist</th>
                                <th class="p-2 table-cell border-b border-[#c28e5c]   ">Bottom Length</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm">
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="p-2 table-cell border-b border-gray-200">32-XS</td>
                                <td class="p-2 table-cell border-b border-gray-200">32</td>
                                <td class="p-2 table-cell border-b border-gray-200">30</td>
                                <td class="p-2 table-cell border-b border-gray-200">15</td>
                                <td class="p-2 table-cell border-b border-gray-200">28</td>
                                <td class="p-2 table-cell border-b border-gray-200">38</td>
                            </tr>
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="p-2 table-cell border-b border-gray-200">34-S</td>
                                <td class="p-2 table-cell border-b border-gray-200">34</td>
                                <td class="p-2 table-cell border-b border-gray-200">32</td>
                                <td class="p-2 table-cell border-b border-gray-200">15.5</td>
                                <td class="p-2 table-cell border-b border-gray-200">30</td>
                                <td class="p-2 table-cell border-b border-gray-200">39</td>
                            </tr>
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="p-2 table-cell border-b border-gray-200">36-M</td>
                                <td class="p-2 table-cell border-b border-gray-200">36</td>
                                <td class="p-2 table-cell border-b border-gray-200">34</td>
                                <td class="p-2 table-cell border-b border-gray-200">16</td>
                                <td class="p-2 table-cell border-b border-gray-200">32</td>
                                <td class="p-2 table-cell border-b border-gray-200">40</td>
                            </tr>
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="p-2 table-cell border-b border-gray-200">38-L</td>
                                <td class="p-2 table-cell border-b border-gray-200">38</td>
                                <td class="p-2 table-cell border-b border-gray-200">36</td>
                                <td class="p-2 table-cell border-b border-gray-200">17</td>
                                <td class="p-2 table-cell border-b border-gray-200">34</td>
                                <td class="p-2 table-cell border-b border-gray-200">40</td>
                            </tr>
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="p-2 table-cell border-b border-gray-200">40-XL</td>
                                <td class="p-2 table-cell border-b border-gray-200">40</td>
                                <td class="p-2 table-cell border-b border-gray-200">38</td>
                                <td class="p-2 table-cell border-b border-gray-200">18</td>
                                <td class="p-2 table-cell border-b border-gray-200">36</td>
                                <td class="p-2 table-cell border-b border-gray-200">40</td>
                            </tr>
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="p-2 table-cell border-b border-gray-200">42-XXL</td>
                                <td class="p-2 table-cell border-b border-gray-200">42</td>
                                <td class="p-2 table-cell border-b border-gray-200">40</td>
                                <td class="p-2 table-cell border-b border-gray-200">18</td>
                                <td class="p-2 table-cell border-b border-gray-200">38</td>
                                <td class="p-2 table-cell border-b border-gray-200">42</td>
                            </tr>
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="p-2 table-cell">44-3XL</td>
                                <td class="p-2 table-cell">44</td>
                                <td class="p-2 table-cell">42</td>
                                <td class="p-2 table-cell">20</td>
                                <td class="p-2 table-cell">40</td>
                                <td class="p-2 table-cell">42</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section>
                <h2 class="text-lg font-bold mb-3 text-gray-800">Lehenga Choli (in inches)</h2>
                <div class="overflow-x-auto custom-scrollbar rounded-xl shadow-lg bg-white border-1 border-[#c28e5c]">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-[#c28e5c] text-white text-sm uppercase tracking-wide">
                            <tr>
                                <th class="p-2 table-cell border-b border-[#c28e5c]   ">Size</th>
                                <th class="p-2 table-cell border-b border-[#c28e5c]">Bust</th>
                                <th class="p-2 table-cell border-b border-[#c28e5c]">Lower Bust</th>
                                <th class="p-2 table-cell border-b border-[#c28e5c]">Lehenga Waist</th>
                                <th class="p-2 table-cell border-b border-[#c28e5c]   ">Lehenga Length</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm">
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="p-2 table-cell border-b border-gray-200">32-XS</td>
                                <td class="p-2 table-cell border-b border-gray-200">32</td>
                                <td class="p-2 table-cell border-b border-gray-200">28</td>
                                <td class="p-2 table-cell border-b border-gray-200">30</td>
                                <td class="p-2 table-cell border-b border-gray-200">38</td>
                            </tr>
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="p-2 table-cell border-b border-gray-200">34-S</td>
                                <td class="p-2 table-cell border-b border-gray-200">34</td>
                                <td class="p-2 table-cell border-b border-gray-200">30</td>
                                <td class="p-2 table-cell border-b border-gray-200">32</td>
                                <td class="p-2 table-cell border-b border-gray-200">39</td>
                            </tr>
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="p-2 table-cell border-b border-gray-200">36-M</td>
                                <td class="p-2 table-cell border-b border-gray-200">36</td>
                                <td class="p-2 table-cell border-b border-gray-200">32</td>
                                <td class="p-2 table-cell border-b border-gray-200">34</td>
                                <td class="p-2 table-cell border-b border-gray-200">40</td>
                            </tr>
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="p-2 table-cell border-b border-gray-200">38-L</td>
                                <td class="p-2 table-cell border-b border-gray-200">38</td>
                                <td class="p-2 table-cell border-b border-gray-200">34</td>
                                <td class="p-2 table-cell border-b border-gray-200">36</td>
                                <td class="p-2 table-cell border-b border-gray-200">40</td>
                            </tr>
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="p-2 table-cell border-b border-gray-200">40-XL</td>
                                <td class="p-2 table-cell border-b border-gray-200">40</td>
                                <td class="p-2 table-cell border-b border-gray-200">36</td>
                                <td class="p-2 table-cell border-b border-gray-200">38</td>
                                <td class="p-2 table-cell border-b border-gray-200">40</td>
                            </tr>
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="p-2 table-cell border-b border-gray-200">42-XXL</td>
                                <td class="p-2 table-cell border-b border-gray-200">42</td>
                                <td class="p-2 table-cell border-b border-gray-200">38</td>
                                <td class="p-2 table-cell border-b border-gray-200">40</td>
                                <td class="p-2 table-cell border-b border-gray-200">42</td>
                            </tr>
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="p-2 table-cell">44-3XL</td>
                                <td class="p-2 table-cell">44</td>
                                <td class="p-2 table-cell">40</td>
                                <td class="p-2 table-cell">42</td>
                                <td class="p-2 table-cell">42</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section>
                <h2 class="text-lg font-bold mb-3 text-gray-800">Men's (in inches)</h2>
                <div class="overflow-x-auto custom-scrollbar rounded-xl shadow-lg bg-white border-1 border-[#c28e5c]">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-[#c28e5c] text-white text-sm uppercase tracking-wide">
                            <tr>
                                <th class="p-2 table-cell border-b border-[#c28e5c]   ">Standard Size</th>
                                <th class="p-2 table-cell border-b border-[#c28e5c]">Chest</th>
                                <th class="p-2 table-cell border-b border-[#c28e5c]">Waist</th>
                                <th class="p-2 table-cell border-b border-[#c28e5c]">Shoulder</th>
                                <th class="p-2 table-cell border-b border-[#c28e5c]">Bottom Waist</th>
                                <th class="p-2 table-cell border-b border-[#c28e5c]">Hips</th>
                                <th class="p-2 table-cell border-b border-[#c28e5c]">Bottom Length</th>
                                <th class="p-2 table-cell border-b border-[#c28e5c]">Bicep</th>
                                <th class="p-2 table-cell border-b border-[#c28e5c]   ">Sleeve Length</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm">
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="p-2 table-cell border-b border-gray-200">36-M</td>
                                <td class="p-2 table-cell border-b border-gray-200">40</td>
                                <td class="p-2 table-cell border-b border-gray-200">37</td>
                                <td class="p-2 table-cell border-b border-gray-200">17</td>
                                <td class="p-2 table-cell border-b border-gray-200">33</td>
                                <td class="p-2 table-cell border-b border-gray-200">41</td>
                                <td class="p-2 table-cell border-b border-gray-200">41</td>
                                <td class="p-2 table-cell border-b border-gray-200">14</td>
                                <td class="p-2 table-cell border-b border-gray-200">25</td>
                            </tr>
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="p-2 table-cell border-b border-gray-200">38-L</td>
                                <td class="p-2 table-cell border-b border-gray-200">42</td>
                                <td class="p-2 table-cell border-b border-gray-200">38</td>
                                <td class="p-2 table-cell border-b border-gray-200">17.5</td>
                                <td class="p-2 table-cell border-b border-gray-200">34</td>
                                <td class="p-2 table-cell border-b border-gray-200">42</td>
                                <td class="p-2 table-cell border-b border-gray-200">41</td>
                                <td class="p-2 table-cell border-b border-gray-200">15</td>
                                <td class="p-2 table-cell border-b border-gray-200">25.5</td>
                            </tr>
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="p-2 table-cell border-b border-gray-200">40-XL</td>
                                <td class="p-2 table-cell border-b border-gray-200">44</td>
                                <td class="p-2 table-cell border-b border-gray-200">40</td>
                                <td class="p-2 table-cell border-b border-gray-200">18</td>
                                <td class="p-2 table-cell border-b border-gray-200">36</td>
                                <td class="p-2 table-cell border-b border-gray-200">45</td>
                                <td class="p-2 table-cell border-b border-gray-200">41</td>
                                <td class="p-2 table-cell border-b border-gray-200">15.5</td>
                                <td class="p-2 table-cell border-b border-gray-200">26</td>
                            </tr>
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="p-2 table-cell border-b border-gray-200">42-XXL</td>
                                <td class="p-2 table-cell border-b border-gray-200">46</td>
                                <td class="p-2 table-cell border-b border-gray-200">42</td>
                                <td class="p-2 table-cell border-b border-gray-200">18.5</td>
                                <td class="p-2 table-cell border-b border-gray-200">38</td>
                                <td class="p-2 table-cell border-b border-gray-200">46</td>
                                <td class="p-2 table-cell border-b border-gray-200">41</td>
                                <td class="p-2 table-cell border-b border-gray-200">16</td>
                                <td class="p-2 table-cell border-b border-gray-200">26.5</td>
                            </tr>
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="p-2 table-cell border-b border-gray-200">44-3XL</td>
                                <td class="p-2 table-cell border-b border-gray-200">48</td>
                                <td class="p-2 table-cell border-b border-gray-200">44</td>
                                <td class="p-2 table-cell border-b border-gray-200">19</td>
                                <td class="p-2 table-cell border-b border-gray-200">39</td>
                                <td class="p-2 table-cell border-b border-gray-200">49</td>
                                <td class="p-2 table-cell border-b border-gray-200">41</td>
                                <td class="p-2 table-cell border-b border-gray-200">16.5</td>
                                <td class="p-2 table-cell border-b border-gray-200">26.5</td>
                            </tr>
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="p-2 table-cell border-b border-gray-200">46-4XL</td>
                                <td class="p-2 table-cell border-b border-gray-200">50</td>
                                <td class="p-2 table-cell border-b border-gray-200">46</td>
                                <td class="p-2 table-cell border-b border-gray-200">19.5</td>
                                <td class="p-2 table-cell border-b border-gray-200">42</td>
                                <td class="p-2 table-cell border-b border-gray-200">52</td>
                                <td class="p-2 table-cell border-b border-gray-200">42</td>
                                <td class="p-2 table-cell border-b border-gray-200">17</td>
                                <td class="p-2 table-cell border-b border-gray-200">26.5</td>
                            </tr>
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="p-2 table-cell border-b border-gray-200">48-5XL</td>
                                <td class="p-2 table-cell border-b border-gray-200">52</td>
                                <td class="p-2 table-cell border-b border-gray-200">48</td>
                                <td class="p-2 table-cell border-b border-gray-200">20.5</td>
                                <td class="p-2 table-cell border-b border-gray-200">44</td>
                                <td class="p-2 table-cell border-b border-gray-200">54</td>
                                <td class="p-2 table-cell border-b border-gray-200">42</td>
                                <td class="p-2 table-cell border-b border-gray-200">17.5</td>
                                <td class="p-2 table-cell border-b border-gray-200">27</td>
                            </tr>
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="p-2 table-cell border-b border-gray-200">50-6XL</td>
                                <td class="p-2 table-cell border-b border-gray-200">55</td>
                                <td class="p-2 table-cell border-b border-gray-200">50</td>
                                <td class="p-2 table-cell border-b border-gray-200">21</td>
                                <td class="p-2 table-cell border-b border-gray-200">46</td>
                                <td class="p-2 table-cell border-b border-gray-200">56</td>
                                <td class="p-2 table-cell border-b border-gray-200">42</td>
                                <td class="p-2 table-cell border-b border-gray-200">18</td>
                                <td class="p-2 table-cell border-b border-gray-200">27</td>
                            </tr>
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="p-2 table-cell border-b border-gray-200">52-7XL</td>
                                <td class="p-2 table-cell border-b border-gray-200">57</td>
                                <td class="p-2 table-cell border-b border-gray-200">52</td>
                                <td class="p-2 table-cell border-b border-gray-200">21.5</td>
                                <td class="p-2 table-cell border-b border-gray-200">48</td>
                                <td class="p-2 table-cell border-b border-gray-200">58</td>
                                <td class="p-2 table-cell border-b border-gray-200">42</td>
                                <td class="p-2 table-cell border-b border-gray-200">18.5</td>
                                <td class="p-2 table-cell border-b border-gray-200">27</td>
                            </tr>
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="p-2 table-cell border-b border-gray-200">54-8XL</td>
                                <td class="p-2 table-cell border-b border-gray-200">59</td>
                                <td class="p-2 table-cell border-b border-gray-200">54</td>
                                <td class="p-2 table-cell border-b border-gray-200">21.5</td>
                                <td class="p-2 table-cell border-b border-gray-200">50</td>
                                <td class="p-2 table-cell border-b border-gray-200">58</td>
                                <td class="p-2 table-cell border-b border-gray-200">42</td>
                                <td class="p-2 table-cell border-b border-gray-200">19</td>
                                <td class="p-2 table-cell border-b border-gray-200">27</td>
                            </tr>
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="p-2 table-cell">56-9XL</td>
                                <td class="p-2 table-cell">61</td>
                                <td class="p-2 table-cell">56</td>
                                <td class="p-2 table-cell">22</td>
                                <td class="p-2 table-cell">52</td>
                                <td class="p-2 table-cell">61</td>
                                <td class="p-2 table-cell">42</td>
                                <td class="p-2 table-cell">19</td>
                                <td class="p-2 table-cell">27</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

        </div>
    </main>

    <footer class="pt-8 bg-gray-100">
        <?php include('main_footer.php'); ?>
    </footer>
</body>

</html>