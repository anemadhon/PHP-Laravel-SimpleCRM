<div class="hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center" id="small-modal-id">
    <div class="relative w-auto my-6 mx-auto max-w-sm">
        <!--content-->
        <div class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
            <!--header-->
            <div class="flex items-start justify-between p-5 border-b border-solid border-blueGray-200 rounded-t">
                <h3 class="text-3xl font-semibold"></h3>
                <button class="p-1 ml-auto bg-transparent border-0 text-black float-right text-3xl leading-none font-semibold outline-none focus:outline-none" onclick="toggleModal('small-modal-id')">
                    <span class="bg-transparent text-black h-6 w-6 text-2xl block outline-none focus:outline-none">
                    ×
                    </span>
                </button>
            </div>
            <!--body-->
            <div class="relative p-6 flex-auto">
                <p class="my-4 text-blueGray-500 text-lg leading-relaxed"></p>
            </div>
            <!--footer-->
            <div class="flex items-center justify-end p-6 border-t border-solid border-blueGray-200 rounded-b">
                <a href="">
                    <button class="bg-emerald-500 text-white active:bg-emerald-600 font-bold uppercase text-xs px-4 py-2 rounded-full shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150" type="button">
                        <i class="fas fa-pen"></i> {{ __('Edit') }}
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="small-modal-id-backdrop"></div>