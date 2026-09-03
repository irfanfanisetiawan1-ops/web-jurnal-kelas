{{-- Live Date & Time + Current Lesson Hour Widget Component --}}
@php
    $hariIndo = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    $bulanIndo = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $now = \Carbon\Carbon::now('Asia/Jakarta');
    $initialDate = $hariIndo[$now->dayOfWeek] . ', ' . $now->day . ' ' . $bulanIndo[$now->month] . ' ' . $now->year;
    $initialTime = $now->format('H:i:s') . ' WIB';

    $allJamPelajaran = \App\Models\JamPelajaran::orderBy('id_jam', 'asc')->get();
    $initialLessonStatus = \App\Models\JamPelajaran::getCurrentLessonStatus($now);
@endphp

<div class="live-clock-wrapper">
    {{-- Fitur Jam Pelajaran Saat Ini (Di sebelah kiri Jam Digital) --}}
    <div class="live-lesson-hour-card" id="liveLessonHourCard" style="background-color: {{ $initialLessonStatus['bg'] }}; border-color: {{ $initialLessonStatus['border'] }};">
        <div class="lesson-icon" id="liveLessonHourIcon" style="color: {{ $initialLessonStatus['color'] }};">
            <i class="fa-solid {{ $initialLessonStatus['icon'] }}"></i>
        </div>
        <div class="lesson-details">
            <div class="lesson-title live-lesson-hour-title" style="color: {{ $initialLessonStatus['color'] }};">{{ $initialLessonStatus['label'] }}</div>
            <div class="lesson-subtitle live-lesson-hour-subtitle">{{ $initialLessonStatus['detail'] }}</div>
        </div>
    </div>

    {{-- Widget Tanggal & Jam Digital --}}
    <div class="live-clock-card">
        <div class="clock-icon">
            <i class="fa-solid fa-calendar-days"></i>
        </div>
        <div class="clock-details">
            <div class="clock-date live-clock-date">{{ $initialDate }}</div>
            <div class="clock-time live-clock-time">{{ $initialTime }}</div>
        </div>
    </div>
</div>

@once
<style>
    .live-clock-wrapper {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        flex-wrap: nowrap;
    }

    .live-lesson-hour-card {
        background-color: #e0f2fe;
        border: 1px solid #93c5fd;
        border-radius: 12px;
        padding: 7px 15px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        font-family: 'Plus Jakarta Sans', sans-serif;
        transition: all 0.3s ease;
    }

    .live-lesson-hour-card .lesson-icon {
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .live-lesson-hour-card .lesson-details {
        display: flex;
        flex-direction: column;
        justify-content: center;
        line-height: 1.25;
    }

    .live-lesson-hour-card .lesson-title {
        font-size: 13px;
        font-weight: 800;
        letter-spacing: -0.01em;
        white-space: nowrap;
    }

    .live-lesson-hour-card .lesson-subtitle {
        font-size: 11.5px;
        font-weight: 700;
        color: #475569;
        margin-top: 1px;
        white-space: nowrap;
    }

    .live-clock-card {
        background-color: #f1f5f9;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        padding: 7px 15px;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .live-clock-card .clock-icon {
        font-size: 20px;
        color: #384972;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .live-clock-card .clock-details {
        display: flex;
        flex-direction: column;
        justify-content: center;
        line-height: 1.25;
    }

    .live-clock-card .clock-date {
        font-size: 13px;
        font-weight: 800;
        color: #1e293b;
        letter-spacing: -0.01em;
        white-space: nowrap;
    }

    .live-clock-card .clock-time {
        font-size: 12.5px;
        font-weight: 700;
        color: #475569;
        margin-top: 1px;
        white-space: nowrap;
    }

    @media (max-width: 768px) {
        .live-clock-wrapper {
            flex-wrap: wrap;
            gap: 6px;
        }
        .live-lesson-hour-card,
        .live-clock-card {
            padding: 5px 10px;
            gap: 8px;
            border-radius: 10px;
        }
        .live-lesson-hour-card .lesson-icon,
        .live-clock-card .clock-icon {
            font-size: 16px;
        }
        .live-lesson-hour-card .lesson-title,
        .live-clock-card .clock-date {
            font-size: 11.5px;
        }
        .live-lesson-hour-card .lesson-subtitle,
        .live-clock-card .clock-time {
            font-size: 11px;
        }
    }
</style>

<script>
    (function() {
        const jamPelajaranData = @json($allJamPelajaran);

        function getLessonStatus(now) {
            const dayOfWeek = now.getDay(); // 0: Sun, 1: Mon, ..., 5: Fri, 6: Sat
            const jam = String(now.getHours()).padStart(2, '0');
            const menit = String(now.getMinutes()).padStart(2, '0');
            const detik = String(now.getSeconds()).padStart(2, '0');
            const timeStr = `${jam}:${menit}:${detik}`;

            if (dayOfWeek === 0 || dayOfWeek === 6) {
                return {
                    status: 'off',
                    label: 'Luar Jam KBM',
                    detail: 'Libur Akhir Pekan',
                    icon: 'fa-moon',
                    color: '#64748b',
                    bg: '#f1f5f9',
                    border: '#cbd5e1'
                };
            }

            const isJumat = (dayOfWeek === 5);

            if (timeStr < '07:00:00') {
                return {
                    status: 'before',
                    label: 'Sebelum KBM',
                    detail: `KBM ${isJumat ? 'Jumat ' : ''}Mulai 07:00 WIB`,
                    icon: 'fa-clock',
                    color: '#0369a1',
                    bg: '#e0f2fe',
                    border: '#93c5fd'
                };
            }

            let activeSlot = null;
            for (let i = 0; i < jamPelajaranData.length; i++) {
                const j = jamPelajaranData[i];
                let start = isJumat ? j.jam_mulai_jumat : j.jam_mulai;
                let end   = isJumat ? j.jam_selesai_jumat : j.jam_selesai;

                if (!start || !end || start === '-' || end === '-') continue;

                // Format to HH:MM:SS
                if (start.length === 5) start += ':00';
                if (end.length === 5) end += ':00';

                if (timeStr >= start && timeStr < end) {
                    activeSlot = {
                        jam_ke: j.jam_ke,
                        start: start.substring(0, 5),
                        end: end.substring(0, 5)
                    };
                    break;
                }
            }

            if (activeSlot) {
                const labelStr = String(activeSlot.jam_ke).startsWith('Jam Ke-') ? activeSlot.jam_ke : `Jam Ke-${activeSlot.jam_ke}`;
                return {
                    status: 'active',
                    label: labelStr,
                    detail: `${activeSlot.start} - ${activeSlot.end} WIB`,
                    icon: 'fa-clock-rotate-left',
                    color: '#15803d',
                    bg: '#dcfce7',
                    border: '#86efac'
                };
            }

            const maxEnd = isJumat ? '15:30:00' : '15:00:00';
            if (timeStr >= maxEnd) {
                return {
                    status: 'after',
                    label: 'KBM Selesai',
                    detail: 'Kegiatan KBM Hari Ini Selesai',
                    icon: 'fa-flag-checkered',
                    color: '#475569',
                    bg: '#f1f5f9',
                    border: '#cbd5e1'
                };
            }

            // Sesi Istirahat
            if (isJumat) {
                if (timeStr >= '11:20:00' && timeStr < '13:00:00') {
                    return {
                        status: 'break',
                        label: 'Istirahat (Jumatan)',
                        detail: '11:20 - 13:00 WIB',
                        icon: 'fa-mosque',
                        color: '#b45309',
                        bg: '#fef3c7',
                        border: '#fde68a'
                    };
                }
                if (timeStr >= '09:30:00' && timeStr < '09:50:00') {
                    return {
                        status: 'break',
                        label: 'Istirahat 1',
                        detail: '09:30 - 09:50 WIB',
                        icon: 'fa-mug-hot',
                        color: '#b45309',
                        bg: '#fef3c7',
                        border: '#fde68a'
                    };
                }
            } else {
                if (timeStr >= '11:45:00' && timeStr < '13:15:00') {
                    return {
                        status: 'break',
                        label: 'Istirahat 2 (ISHOMA)',
                        detail: '11:45 - 13:15 WIB',
                        icon: 'fa-utensils',
                        color: '#b45309',
                        bg: '#fef3c7',
                        border: '#fde68a'
                    };
                }
                if (timeStr >= '09:40:00' && timeStr < '10:00:00') {
                    return {
                        status: 'break',
                        label: 'Istirahat 1',
                        detail: '09:40 - 10:00 WIB',
                        icon: 'fa-mug-hot',
                        color: '#b45309',
                        bg: '#fef3c7',
                        border: '#fde68a'
                    };
                }
            }

            return {
                status: 'break',
                label: 'Sesi Istirahat',
                detail: 'Sesi Istirahat KBM',
                icon: 'fa-mug-hot',
                color: '#b45309',
                bg: '#fef3c7',
                border: '#fde68a'
            };
        }

        function updateLiveClock() {
            const now = new Date();
            const hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            
            const namaHari = hari[now.getDay()];
            const tgl = now.getDate();
            const namaBulan = bulan[now.getMonth()];
            const tahun = now.getFullYear();
            
            const jam = String(now.getHours()).padStart(2, '0');
            const menit = String(now.getMinutes()).padStart(2, '0');
            const detik = String(now.getSeconds()).padStart(2, '0');
            
            const dateStr = `${namaHari}, ${tgl} ${namaBulan} ${tahun}`;
            const timeStr = `${jam}:${menit}:${detik} WIB`;
            
            const dateElements = document.querySelectorAll('.live-clock-date');
            const timeElements = document.querySelectorAll('.live-clock-time');
            
            dateElements.forEach(el => el.textContent = dateStr);
            timeElements.forEach(el => el.textContent = timeStr);

            // Update Current Lesson Hour Status
            const st = getLessonStatus(now);
            const lessonCards = document.querySelectorAll('#liveLessonHourCard, .live-lesson-hour-card');
            lessonCards.forEach(card => {
                card.style.backgroundColor = st.bg;
                card.style.borderColor = st.border;

                const iconDiv = card.querySelector('.lesson-icon');
                if (iconDiv) {
                    iconDiv.style.color = st.color;
                    iconDiv.innerHTML = `<i class="fa-solid ${st.icon}"></i>`;
                }

                const titleDiv = card.querySelector('.live-lesson-hour-title');
                if (titleDiv) {
                    titleDiv.style.color = st.color;
                    titleDiv.textContent = st.label;
                }

                const subDiv = card.querySelector('.live-lesson-hour-subtitle');
                if (subDiv) {
                    subDiv.textContent = st.detail;
                }
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                updateLiveClock();
                setInterval(updateLiveClock, 1000);
            });
        } else {
            updateLiveClock();
            setInterval(updateLiveClock, 1000);
        }
    })();
</script>
@endonce
