<script setup>
</script>
<template>
    <footer class="flex flex-col items-center p-4 bg-neutral text-neutral-content h-80 bg-black/25 divide-y space-y-2">
        <div class="h-5/6 w-full flex justify-between">
            <div class="space-y-1 flex flex-col items-start w-1/4">
                <span class="font-bold text-white text-left underline pl-1">Trouver votre plaisir</span>
                <router-link to="/model"
                    class="rounded-lg p-1 text-slate-200 hover:bg-inherit text-left cursor-pointer min-w-full">Models</router-link>
                <router-link to="/e-brid"
                    class="rounded-lg p-1 text-slate-200 hover:bg-inherit text-left cursor-pointer min-w-full">Electrique
                    &
                    Hybride Rechargeable
                </router-link>
                <router-link to="/services"
                    class="rounded-lg p-1 text-slate-200 hover:bg-inherit text-left cursor-pointer min-w-full">
                    Services
                </router-link>
                <router-link to="/garage"
                    class="rounded-lg p-1 text-slate-200 hover:bg-inherit text-left cursor-pointer min-w-full">
                    Nos concessionaires
                </router-link>
            </div>
            <div class="space-y-1 flex flex-col items-end w-2/4">
                <span class="font-bold text-white text-left underline pl-1">Retrouvez nous sur d'autres site</span>
                <a href="https://www.bmw.be/fr/topics/fascination-bmw/jobs.html"
                    class="hover:underline cursor-pointer p-1 text-slate-200" target="_blank">Jobs</a>
                <a href="https://www.bmw.be/fr/topics/fascination-bmw/bmw-group.html"
                    class="hover:underline cursor-pointer p-1 text-slate-200" target="_blank">BMW
                    Group</a>
                <a href="https://www.bmw.be/content/dam/bmw/marketBE/common/pdf/connected-drive/11-2022/BMW_CD_PP_BE-FR_2022.07.pdf"
                    class="hover:underline cursor-pointer p-1 text-slate-200" target="_blank">Connected
                    Drive Privacy Policy</a>
                <a href="https://www.bmw.be/content/dam/bmw/marketBE/common/pdf/connected-drive/11-2022/BMW_CD_TC_BE-FR_2022.11_Final.pdf"
                    class="hover:underline cursor-pointer p-1 text-slate-200" target="_blank">Connected
                    Drive Terms & Conditions</a>
            </div>
        </div>
        <div class="flex justify-end items-end w-full h-full space-x-2 flex-col">
            <div className="flex items-center">
                <p>Copyright © 2023 - All right reserved -
                    <a href="https://github.com/esgi-insomniak" target="_blank"
                        className='underline underline-offset-2 decoration-blue-400'>Insomniak</a>
                </p>
            </div>
            <div className="flex space-x-3">
                <a href="https://github.com/TheHikuro" target="_blank"
                    className='underline underline-offset-2 decoration-blue-200 text-slate-200'>Loan CLERIS</a>
                <a href="https://github.com/Frozox" target="_blank"
                    className='underline underline-offset-2 decoration-blue-200 text-slate-200'>Tom CUILLANDRE</a>
                <a href="https://github.com/MaelStorm176" target="_blank"
                    className='underline underline-offset-2 decoration-blue-200 text-slate-200'>Maël JAMIN</a>
                <a href="https://github.com/ThePrimesBros" target="_blank"
                    className='underline underline-offset-2 decoration-blue-200 text-slate-200'>Raphaël BESSIONIER</a>
            </div>
        </div>
    </footer>
</template>