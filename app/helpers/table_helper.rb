module TableHelper
	
	def table_for
		builder = TableBuilder
		
		content_tag(:table) do
			yield builder.new
		end #end table
	end #end table_for
	
	class TableBuilder
		include ::ActionView::Helpers::TagHelper
		
		def head(*args)
			content_tag(:thead,
          content_tag(:tr,
            args.collect { |c| content_tag(:th, c.html_safe)}.join('').html_safe
          )
        )
		end #end head method
			
		def body(*args)
			raise ArgumentError, "Missing block" unless block_given?
		end #end body method
		
	end #end TableBuilder class
end #end module