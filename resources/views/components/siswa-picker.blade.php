@props([
    'siswas' => [],
    'selected' => null,
    'name' => 'siswa_id',
    'label' => 'Pilih Peserta Didik',
    'required' => true,
])

@php
    // siapkan data ringkas siswa untuk alpine
    $studentsData = collect($siswas)->map(function ($s) {
        return [
            'id' => $s->id,
            'nama' => $s->nama,
            'nis' => $s->nis,
            'kelas' => $s->kelas,
        ];
    })->values();

    $initialSelectedId = old($name, $selected);
    $initialStudent = $initialSelectedId ? $studentsData->firstWhere('id', (int) $initialSelectedId) : null;
    $availableClasses = $studentsData->pluck('kelas')->filter()->unique()->sort()->values();
@endphp

<div
    x-data="{
        allStudents: {{ Js::from($studentsData) }},
        search: '',
        selectedClass: 'all',
        selectedId: {{ $initialSelectedId ? (int) $initialSelectedId : 'null' }},
        selectedStudent: {{ $initialStudent ? Js::from($initialStudent) : 'null' }},
        inputName: '{{ $name }}',
        isRequired: {{ $required ? 'true' : 'false' }},

        get filteredStudents() {
            let list = this.allStudents;

            if (this.selectedClass !== 'all') {
                list = list.filter(s => s.kelas === this.selectedClass);
            }

            if (this.search.trim() !== '') {
                const q = this.search.toLowerCase().trim();
                list = list.filter(s =>
                    (s.nama && s.nama.toLowerCase().includes(q)) ||
                    (s.nis && s.nis.toLowerCase().includes(q))
                );
            }

            // batasi maksimal 12 data untuk menjaga performa dom
            return list.slice(0, 12);
        },

        select(student) {
            this.selectedId = student.id;
            this.selectedStudent = student;
            this.search = '';
        },

        clear() {
            this.selectedId = null;
            this.selectedStudent = null;
            this.search = '';
        }
    }"
    class="space-y-2 text-xs"
>
    <!-- label field -->
    <div class="flex items-center justify-between">
        <label class="block font-semibold text-slate-700">
            {{ $label }}
            @if($required) <span class="text-rose-500">*</span> @endif
        </label>
        <span x-show="selectedStudent" class="text-[11px] text-emerald-600 font-semibold flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            Siswa Terpilih
        </span>
    </div>

    <!-- input hidden untuk request form post -->
    <input type="hidden" :name="inputName" :value="selectedId ?? ''" :required="isRequired">

    <!-- tampilan ketika siswa sudah dipilih -->
    <template x-if="selectedStudent">
        <div class="p-3 bg-pink-50/60 border border-pink-200 rounded-lg flex items-center justify-between gap-3 shadow-2xs">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-8 h-8 rounded bg-pink-500 text-white font-bold flex items-center justify-center text-xs shrink-0">
                    <span x-text="selectedStudent.nama.charAt(0)"></span>
                </div>
                <div class="min-w-0">
                    <div class="font-bold text-slate-900 truncate" x-text="selectedStudent.nama"></div>
                    <div class="text-[11px] text-slate-500 flex items-center gap-2">
                        <span>NIS: <strong class="font-mono text-slate-700" x-text="selectedStudent.nis"></strong></span>
                        <span>•</span>
                        <span class="px-1.5 py-0.2 rounded bg-white border border-pink-200 text-pink-700 font-semibold text-[10px]" x-text="selectedStudent.kelas"></span>
                    </div>
                </div>
            </div>
            <button
                type="button"
                @click="clear()"
                class="px-2.5 py-1 text-[11px] font-semibold text-pink-600 hover:text-pink-700 bg-white hover:bg-pink-100/50 border border-pink-200 rounded transition-colors shrink-0"
            >
                Ganti Siswa
            </button>
        </div>
    </template>

    <!-- bilah pencarian & daftar hasil saat belum memilih -->
    <template x-if="!selectedStudent">
        <div class="space-y-2">
            <!-- filter kelas dan input search bar -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                <div class="sm:col-span-1">
                    <select
                        x-model="selectedClass"
                        class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-2.5 bg-white text-slate-700"
                    >
                        <option value="all">Semua Rombel</option>
                        @foreach($availableClasses as $cls)
                            <option value="{{ $cls }}">{{ $cls }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:col-span-2 relative">
                    <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input
                        type="text"
                        x-model="search"
                        placeholder="Cari nama atau NIS siswa..."
                        class="w-full pl-8 pr-3 py-2 text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 bg-white"
                    >
                </div>
            </div>

            <!-- daftar opsi hasil pencarian (dibatasi max 12) -->
            <div class="border border-slate-200 rounded-lg overflow-hidden bg-white max-h-48 overflow-y-auto shadow-2xs divide-y divide-slate-100">
                <template x-for="item in filteredStudents" :key="item.id">
                    <button
                        type="button"
                        @click="select(item)"
                        class="w-full text-left px-3 py-2 hover:bg-pink-50/50 flex items-center justify-between gap-2 transition-colors group"
                    >
                        <div class="min-w-0">
                            <span class="font-bold text-slate-800 group-hover:text-pink-600 truncate block text-xs" x-text="item.nama"></span>
                            <span class="text-[11px] text-slate-500 font-mono" x-text="'NIS: ' + item.nis"></span>
                        </div>
                        <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-100 group-hover:bg-pink-100 text-slate-600 group-hover:text-pink-700 shrink-0" x-text="item.kelas"></span>
                    </button>
                </template>

                <template x-if="filteredStudents.length === 0">
                    <div class="p-4 text-center text-xs text-slate-400">
                        Tidak ada siswa yang cocok dengan kriteria pencarian.
                    </div>
                </template>
            </div>

            <div class="flex items-center justify-between text-[11px] text-slate-400 px-1">
                <span>Klik siswa untuk memilih</span>
                <span x-text="'Menampilkan ' + filteredStudents.length + ' siswa'"></span>
            </div>
        </div>
    </template>

    @error($name)
        <p class="text-xs text-rose-600 font-semibold">{{ $message }}</p>
    @enderror
</div>
