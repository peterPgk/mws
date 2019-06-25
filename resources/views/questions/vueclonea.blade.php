<vue-cloneya :maximum="5">
    <div class="form-group row" v-cloneya-input>
        <label for="name" class="col-md-3 col-form-label text-md-right">{{ __('Answer') }}</label>
        <div class="col-md-8">
            <div class="input-group">
                <input id="name"
                       type="text"
                       class="form-control @error('answers.*') is-invalid @enderror"
                       name="answers[]"
                       value="{{ $oldData }}"
                       required
                       autocomplete="text"
                       autofocus
                >
                <div class="btn-group" role="group" aria-label="Second group">
                    <button type="button" class="btn btn-secondary" v-cloneya-add>
                        <span class="fa fa-plus font-weight-bold">&#43;</span>
                    </button>
                    <button type="button" class="btn btn-secondary" v-cloneya-remove>
                        <span class="fa fa-minus font-weight-bold">&#8722;</span>
                    </button>
                </div>
            </div>

            <span class="invalid-feedback" role="alert">
                <strong>{{ $err }}</strong>
            </span>
        </div>
    </div>
</vue-cloneya>