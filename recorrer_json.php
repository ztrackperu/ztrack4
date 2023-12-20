      info.permisos.forEach(permiso => {
        let accion = info.asig[permiso.id] ? 'checked' : '';
        
        html += `<div>
            <label class="mb-2">
                <input type="checkbox" name="permisos[]" value="${permiso.id}" ${accion}> ${permiso.nombre}
            </label>
            </div>`;
      });