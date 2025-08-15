<div>
    @if(session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline text-sm">{{ session('error') }}</span>
        </div>
    @endif
    
    @if(!$sertifikatGenerated)
        <div class="relative p-5 min-h-[100px] rounded-lg bg-blue-100 hover:border hover:border-blue-600 transition-all duration-200 flex items-center justify-center overflow-hidden">
            @if($isGenerating)
                <div class="flex flex-col items-center z-20">
                    <div class="relative flex">
                        <div class="absolute -inset-1 rounded-lg bg-blue-600/30 blur-xl animate-pulse"></div>
                        <div class="relative bg-blue-600 text-white rounded-lg px-6 py-1.5 flex items-center">
                            <i class="ti ti-sparkles mr-2 animate-bounce"></i>
                            <span class="font-medium text-sm">Generating Certificate</span>
                            <span class="ml-2 flex gap-1">
                                <span class="animate-pulse delay-75">.</span>
                                <span class="animate-pulse delay-150">.</span>
                                <span class="animate-pulse delay-300">.</span>
                            </span>
                        </div>
                    </div>
                    <p class="text-blue-600 mt-2 text-sm">Mohon tunggu, sertifikat Anda sedang dibuat</p>
                </div>
            @else
                <button wire:click="generateSertifikat" class="hover-gradient-purple w-fit flex items-center text-white transition-all duration-300 ease-in-out font-normal rounded-lg text-sm px-5 py-1.5 text-center z-20 relative overflow-hidden">
                    <i class="ti ti-sparkles mr-2"></i>
                    Generate Certificate
                </button>
            @endif
            <i class="ti ti-file-invoice mr-2 absolute -bottom-14 -left-4 text-[150px] text-blue-300 rotate-[30deg] z-10"></i>
        </div>
    @else
        @if ($magang->sertifikat_magang_temp && !$magang->sertifikat_magang)
            <div class="bg-white rounded-lg card p-5">
                <div class="w-full h-fit p-3 flex flex-col md:flex-row items-start gap-3 md:items-center justify-between bg-amber-100 rounded-lg border text-amber-700 border-amber-700">
                    <div class="flex gap-3 items-start lg:items-center">
                        <i class="ti ti-alert-circle text-lg"></i>
                            <p class="text-sm">Download sertifikat dan berikan sertifikat tanda tangan elektronik dengan sistem yang dimiliki BPS</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg card p-5 mt-6">
                <h6 class="text-[17px] font-semibold text-gray-800">Sertifikat Magang Final</h6>
                <div class="flex flex-col md:flex-row items-center px-2 py-3 mt-3 justify-between text-red-600 border-2 border-dashed border-gray-300 bg-gray-100 rounded-lg">
                    <div class="flex items-center gap-2">
                        <i class="ti ti-file-text text-2xl text-gray-700"></i>
                        @if ($sertifikat_magang)
                            <p class="text-gray-600 text-sm">{{ $sertifikat_magang ? $sertifikat_magang->getClientOriginalName() : basename($magang->sertifikat_magang) }}</p>
                        @else
                            <p class="text-sm">dokumen belum di upload</p>
                        @endif
                    </div>
                    @if ($sertifikat_magang)
                        <div class="flex items-center gap-2">
                            <button type="button"
                                class="px-3 py-2 text-sm text-blue-700 bg-blue-200 rounded-md font-medium transition-all duration-200 hover:bg-blue-600 hover:text-white whitespace-nowrap"
                                onclick="openPreviewPdf('{{ $sertifikat_magang ? $sertifikat_magang->temporaryUrl() : Storage::url($magang->sertifikat_magang) }}')">
                                Lihat file
                            </button>
                            <div>
                                <input type="file" accept=".pdf" name="sertifikat_magang"
                                    id="sertifikat_magang" wire:model.live="sertifikat_magang" class="hidden" />
                                <label for="sertifikat_magang"
                                    class="px-3 py-2 text-sm text-white bg-red-600 rounded-md font-medium transition-all duration-200 hover:bg-red-200 hover:text-red-600 whitespace-nowrap cursor-pointer">
                                    Ganti file
                                </label>
                            </div>
                        </div>
                    @else
                        <div>
                            <input type="file" accept=".pdf" name="sertifikat_magang" id="sertifikat_magang"
                                wire:model.live="sertifikat_magang" class="hidden" />
                            <label for="sertifikat_magang"
                                class="px-3 py-2 text-sm text-blue-700 bg-blue-200 rounded-md font-medium transition-all cursor-pointer duration-200 hover:bg-blue-600 hover:text-white whitespace-nowrap">
                                Upload file
                            </label>
                        </div>
                        @endif
                    </div>
                    @error('sertifikat_magang')
                        <span class="text-red-600 text-[11px]">{{ $message }}</span>
                    @enderror
                <button wire:click="confirmSubmit"
                    class="w-full text-white mt-5 bg-blue-600 hover:bg-blue-700 transition duration-300 ease-in-out focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:cursor-not-allowed disabled:bg-blue-400">
                    Berikan Sertifikat
                </button>
            </div>
        @endif
        <div class="bg-white rounded-lg shadow-md overflow-hidden mt-6">
            <div class="p-4 bg-blue-50 border-b border-blue-100 flex justify-between items-center">
                <h3 class="font-medium text-blue-700 flex items-center">
                    <i class="ti ti-certificate mr-2"></i>
                    Preview Sertifikat Magang
                </h3>

                <button wire:click="downloadSertifikat"
                    class="pjax-link bg-blue-600 ml-7 md:ml-0 border border-transparent px-3 py-1 rounded-lg text-white hover:bg-blue-100 hover:border hover:border-blue-600 hover:text-blue-600 transition-all duration-200 flex items-center">
                    <i class="ti ti-download mr-2"></i>
                    <p class="text-sm whitespace-nowrap">Unduh Sertifikat</p>
                </button>
            </div>
            
            <div class="pdf-viewer h-[80vh] w-full">
                <iframe src="{{ Storage::url($sertifikatPath) }}" class="w-full h-full" frameborder="0"></iframe>
            </div>
            
            <div class="p-4 bg-blue-50 border-t border-blue-100 flex justify-between items-center">
                <button wire:click="$set('sertifikatGenerated', false)" class="text-gray-500 hover:text-gray-700 text-sm flex items-center">
                    <i class="ti ti-refresh mr-1"></i>
                    Generate Ulang
                </button>
                
                <div class="text-sm text-gray-500">
                    <i class="ti ti-clock mr-1"></i>
                    Generated: {{ now()->format('d M Y H:i') }}
                </div>
            </div>
        </div>
    @endif

    @if ($showSubmitModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[1000]">
            <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/3 p-5">
                <div class="flex justify-between items-center border-b pb-4 mb-5">
                    <h2 class="text-lg font-semibold">Konfirmasi Submit</h2>
                    <button wire:click="$set('showSubmitModal', false)" class="text-gray-500 hover:text-gray-700">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                
                <div class="mb-3">
                    <p>Apakah Kamu yakin ingin submit sertifikat magang <span class="font-semibold">{{ $magang->pengajuan->name}}</span>?</p>
                </div>

                <div class="w-full mb-6 h-fit flex gap-3 items-start lg:items-center justify-center px-3 py-2 bg-red-100 rounded-lg border text-red-700 border-red-700">
                    <i class="ti ti-alert-triangle text-lg"></i>
                    <p class="text-sm">karna setelah ini sertifikat tidak dapat diubah</p>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button wire:click="$set('showSubmitModal', false)" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Batal
                    </button>
                    <button wire:click="submitSertifikat" type="button" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Submit Sertifikat
                    </button>
                </div>
            </div>
        </div>
    @endif
    
    <style>
        @keyframes fade-in {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        
        .animate-fade-in {
            animation: fade-in 0.5s ease-in-out;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        .animate-pulse {
            animation: pulse 1.5s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        .delay-75 {
            animation-delay: 0.3s;
        }
        
        .delay-150 {
            animation-delay: 0.6s;
        }
        
        .delay-300 {
            animation-delay: 0.9s;
        }
    </style>
</div>

<!-- Add this in the head section of your layout file -->
<!-- Add this in the head section of your layout file -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
    // Set up PDF.js worker
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
    
    function openPreviewPdf(url) {
        // Create modal container
        const modal = document.createElement('div');
        modal.style.position = 'fixed';
        modal.style.top = '0';
        modal.style.left = '0';
        modal.style.width = '100%';
        modal.style.height = '100%';
        modal.style.backgroundColor = 'rgba(0, 0, 0, 0.7)';
        modal.style.zIndex = '9999';
        modal.style.display = 'flex';
        modal.style.alignItems = 'center';
        modal.style.justifyContent = 'center';
        
        // Create a close button
        const closeBtn = document.createElement('button');
        closeBtn.innerHTML = '&times;';
        closeBtn.style.position = 'absolute';
        closeBtn.style.top = '15px';
        closeBtn.style.right = '15px';
        closeBtn.style.backgroundColor = '#fff';
        closeBtn.style.border = 'none';
        closeBtn.style.borderRadius = '50%';
        closeBtn.style.width = '40px';
        closeBtn.style.height = '40px';
        closeBtn.style.fontSize = '24px';
        closeBtn.style.cursor = 'pointer';
        closeBtn.style.boxShadow = '0 2px 10px rgba(0,0,0,0.2)';
        closeBtn.style.zIndex = '10001';
        closeBtn.onclick = function() {
            document.body.removeChild(modal);
        };
        
        // Create the PDF viewer container
        const container = document.createElement('div');
        container.style.width = '90%';
        container.style.height = '90%';
        container.style.backgroundColor = '#fff';
        container.style.borderRadius = '8px';
        container.style.overflow = 'hidden';
        container.style.boxShadow = '0 4px 20px rgba(0,0,0,0.2)';
        container.style.position = 'relative';
        container.style.display = 'flex';
        container.style.flexDirection = 'column';
        
        // Create wrapper for canvas to handle scrolling
        const canvasWrapper = document.createElement('div');
        canvasWrapper.style.flex = '1';
        canvasWrapper.style.overflow = 'auto';
        canvasWrapper.style.display = 'flex';
        canvasWrapper.style.justifyContent = 'center';
        canvasWrapper.style.alignItems = 'flex-start';
        canvasWrapper.style.padding = '20px';
        canvasWrapper.style.backgroundColor = '#f5f5f5';
        
        // Create canvas for PDF rendering
        const canvas = document.createElement('canvas');
        canvas.style.boxShadow = '0 0 10px rgba(0,0,0,0.2)';
        
        // Create loading indicator
        const loader = document.createElement('div');
        loader.textContent = 'Loading PDF...';
        loader.style.position = 'absolute';
        loader.style.top = '50%';
        loader.style.left = '50%';
        loader.style.transform = 'translate(-50%, -50%)';
        loader.style.color = '#666';
        loader.style.fontSize = '20px';
        
        // Create navigation controls
        const controls = document.createElement('div');
        controls.style.padding = '15px';
        controls.style.backgroundColor = '#f0f0f0';
        controls.style.borderTop = '1px solid #ddd';
        controls.style.display = 'flex';
        controls.style.justifyContent = 'center';
        controls.style.alignItems = 'center';
        controls.style.gap = '15px';
        
        const prevButton = document.createElement('button');
        prevButton.textContent = 'Previous';
        prevButton.style.padding = '8px 15px';
        prevButton.style.backgroundColor = '#1c64f2';
        prevButton.style.color = 'white';
        prevButton.style.border = 'none';
        prevButton.style.borderRadius = '4px';
        prevButton.style.cursor = 'pointer';
        
        const nextButton = document.createElement('button');
        nextButton.textContent = 'Next';
        nextButton.style.padding = '8px 15px';
        nextButton.style.backgroundColor = '#1c64f2';
        nextButton.style.color = 'white';
        nextButton.style.border = 'none';
        nextButton.style.borderRadius = '4px';
        nextButton.style.cursor = 'pointer';
        
        const pageInfo = document.createElement('span');
        pageInfo.style.fontSize = '14px';
        pageInfo.style.fontWeight = 'bold';
        
        const zoomControls = document.createElement('div');
        zoomControls.style.display = 'flex';
        zoomControls.style.alignItems = 'center';
        zoomControls.style.gap = '10px';
        
        const zoomOutBtn = document.createElement('button');
        zoomOutBtn.textContent = '−';
        zoomOutBtn.style.width = '30px';
        zoomOutBtn.style.height = '30px';
        zoomOutBtn.style.borderRadius = '4px';
        zoomOutBtn.style.border = 'none';
        zoomOutBtn.style.backgroundColor = '#ddd';
        zoomOutBtn.style.cursor = 'pointer';
        
        const zoomInBtn = document.createElement('button');
        zoomInBtn.textContent = '+';
        zoomInBtn.style.width = '30px';
        zoomInBtn.style.height = '30px';
        zoomInBtn.style.borderRadius = '4px';
        zoomInBtn.style.border = 'none';
        zoomInBtn.style.backgroundColor = '#ddd';
        zoomInBtn.style.cursor = 'pointer';
        
        const zoomLabel = document.createElement('span');
        zoomLabel.textContent = '100%';
        zoomLabel.style.fontSize = '12px';
        zoomLabel.style.fontWeight = 'bold';
        
        zoomControls.appendChild(zoomOutBtn);
        zoomControls.appendChild(zoomLabel);
        zoomControls.appendChild(zoomInBtn);
        
        controls.appendChild(prevButton);
        controls.appendChild(pageInfo);
        controls.appendChild(nextButton);
        controls.appendChild(zoomControls);
        
        // Append elements
        canvasWrapper.appendChild(canvas);
        container.appendChild(canvasWrapper);
        container.appendChild(controls);
        container.appendChild(loader);
        modal.appendChild(closeBtn);
        modal.appendChild(container);
        document.body.appendChild(modal);
        
        // Variables to track PDF and current page
        let pdfDoc = null;
        let pageNum = 1;
        let pageRendering = false;
        let pageNumPending = null;
        let scale = 1.0;
        
        // Fetch the PDF
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.arrayBuffer();
            })
            .then(arrayBuffer => {
                // Load PDF using PDF.js
                return pdfjsLib.getDocument({ data: arrayBuffer }).promise;
            })
            .then(pdf => {
                pdfDoc = pdf;
                pageInfo.textContent = `Page ${pageNum} of ${pdf.numPages}`;
                
                // Initial render
                renderPage(pageNum);
                
                // Remove loading indicator when PDF is loaded
                container.removeChild(loader);
            })
            .catch(error => {
                container.removeChild(loader);
                const errorMsg = document.createElement('div');
                errorMsg.textContent = `Error loading PDF: ${error.message}`;
                errorMsg.style.position = 'absolute';
                errorMsg.style.top = '50%';
                errorMsg.style.left = '50%';
                errorMsg.style.transform = 'translate(-50%, -50%)';
                errorMsg.style.color = 'red';
                container.appendChild(errorMsg);
                console.error('Error loading PDF:', error);
            });
        
        // Render a page
        function renderPage(num) {
            pageRendering = true;
            
            // Get page
            pdfDoc.getPage(num).then(page => {
                // Determine scale based on viewport size
                const viewport = page.getViewport({ scale: 1.0 });
                
                // Calculate scale to fit to container while maintaining aspect ratio
                const containerWidth = canvasWrapper.clientWidth - 40; // Subtract padding
                const containerHeight = canvasWrapper.clientHeight - 40; // Subtract padding
                
                const scaleX = containerWidth / viewport.width;
                const scaleY = containerHeight / viewport.height;
                
                // Use the smaller scale to ensure the entire page fits
                const fitScale = Math.min(scaleX, scaleY, 1.5); // Cap at 1.5x
                
                // Apply the current scale factor
                const scaledViewport = page.getViewport({ scale: fitScale * scale });
                
                // Set canvas size
                canvas.height = scaledViewport.height;
                canvas.width = scaledViewport.width;
                
                // Render PDF page into canvas context
                const renderContext = {
                    canvasContext: canvas.getContext('2d'),
                    viewport: scaledViewport
                };
                
                const renderTask = page.render(renderContext);
                
                // Wait for rendering to finish
                renderTask.promise.then(() => {
                    pageRendering = false;
                    
                    // Check if there's a pending page
                    if (pageNumPending !== null) {
                        renderPage(pageNumPending);
                        pageNumPending = null;
                    }
                });
            });
            
            // Update page info
            pageInfo.textContent = `Page ${num} of ${pdfDoc.numPages}`;
        }
        
        // Go to previous page
        prevButton.addEventListener('click', () => {
            if (pageNum <= 1) {
                return;
            }
            pageNum--;
            queueRenderPage(pageNum);
        });
        
        // Go to next page
        nextButton.addEventListener('click', () => {
            if (pageNum >= pdfDoc.numPages) {
                return;
            }
            pageNum++;
            queueRenderPage(pageNum);
        });
        
        // Zoom controls
        zoomOutBtn.addEventListener('click', () => {
            if (scale > 0.5) {
                scale -= 0.1;
                zoomLabel.textContent = `${Math.round(scale * 100)}%`;
                renderPage(pageNum);
            }
        });
        
        zoomInBtn.addEventListener('click', () => {
            if (scale < 2.0) {
                scale += 0.1;
                zoomLabel.textContent = `${Math.round(scale * 100)}%`;
                renderPage(pageNum);
            }
        });
        
        // Window resize handler
        const handleResize = () => {
            renderPage(pageNum);
        };
        
        window.addEventListener('resize', handleResize);
        
        // Clean up event listener when modal is closed
        closeBtn.addEventListener('click', () => {
            window.removeEventListener('resize', handleResize);
        });
        
        // Queue page rendering
        function queueRenderPage(num) {
            if (pageRendering) {
                pageNumPending = num;
            } else {
                renderPage(num);
            }
        }
    }
    
    document.addEventListener('livewire:initialized', () => {
        @this.on('sertifikatGenerated', () => {
            const pdfViewer = document.querySelector('.pdf-viewer');
            if (pdfViewer) {
                pdfViewer.classList.add('animate-fade-in');
            }
        });
        
        @this.on('generatePdf', () => {
            setTimeout(() => {
                @this.doPdfGeneration();
            }, 100);
        });
    });

    function openPreview(url) {
        const screenWidth = window.screen.width;
        const screenHeight = window.screen.height;
        const width = screenWidth / 2;
        const height = screenHeight / 2;
        const left = (screenWidth - width) / 2;
        const top = (screenHeight - height) / 2;

        const newWindow = window.open(
            '',
            '',
            `width=${width},height=${height},top=${top},left=${left}`
        );

        if (newWindow) {
            newWindow.document.write('<img src="' + url + '" style="width:100%;height:auto;">');
            newWindow.document.title = "Image Preview";
        } else {
            alert('Preview dokumen tidak tersedia di tampilan mobile');
        }
    }
</script>