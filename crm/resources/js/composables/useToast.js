import { toast } from 'sonner'

export function useToast() {
  return {
    success: (message, options = {}) => {
      return toast.success(message, {
        duration: 4000,
        ...options
      })
    },

    error: (message, options = {}) => {
      return toast.error(message, {
        duration: 6000,
        ...options
      })
    },

    warning: (message, options = {}) => {
      return toast.warning(message, {
        duration: 5000,
        ...options
      })
    },

    info: (message, options = {}) => {
      return toast.info(message, {
        duration: 4000,
        ...options
      })
    },

    loading: (message, options = {}) => {
      return toast.loading(message, {
        duration: Infinity,
        ...options
      })
    },

    promise: (promise, messages, options = {}) => {
      return toast.promise(promise, messages, options)
    }
  }
}

export const toastMessages = {
  colaboradorCriado: '✅ Colaborador criado com sucesso!',
  colaboradorAtualizado: '✅ Colaborador atualizado com sucesso!',
  colaboradorExcluido: '✅ Colaborador excluído com sucesso!',
  loginSucesso: '✅ Login realizado com sucesso!',
  logoutSucesso: '✅ Logout realizado com sucesso!',
  
  erroGenerico: '❌ Ocorreu um erro inesperado. Tente novamente.',
  erroServidor: '❌ Erro interno do servidor. Tente novamente mais tarde.',
  erroValidacao: '❌ Verifique os dados informados e tente novamente.',
  
  emailJaExiste: '❌ Este e-mail já está cadastrado na sua empresa.',
  telefoneJaExiste: '❌ Este telefone já está cadastrado na sua empresa.',
  emailObrigatorio: '❌ O campo e-mail é obrigatório.',
  nomeObrigatorio: '❌ O campo nome é obrigatório.',
  telefoneObrigatorio: '❌ O campo telefone é obrigatório.',
  cargoObrigatorio: '❌ O campo cargo é obrigatório.',
  departamentoObrigatorio: '❌ O campo departamento é obrigatório.',
  salarioObrigatorio: '❌ O campo salário é obrigatório.',
  dataAdmissaoObrigatoria: '❌ O campo data de admissão é obrigatório.',
  
  credenciaisInvalidas: '❌ E-mail ou senha incorretos.',
  usuarioNaoEncontrado: '❌ Usuário não encontrado.',
  contaDesativada: '❌ Sua conta foi desativada.',
  
  confirmarExclusao: '⚠️ Tem certeza que deseja excluir este colaborador?',
  dadosNaoSalvos: '⚠️ Você tem alterações não salvas.',
  
  carregando: '⏳ Carregando...',
  salvando: '⏳ Salvando...',
  excluindo: '⏳ Excluindo...',
  
  emailEnviado: '📧 E-mail de boas-vindas enviado com sucesso!',
  erroEnvioEmail: '❌ Erro ao enviar e-mail de boas-vindas.'
}
