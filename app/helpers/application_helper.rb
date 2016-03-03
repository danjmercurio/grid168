module ApplicationHelper
	def display_date(date)
		date.strftime "%m/%d/%Y"
	end

	# display 1 array string
	def display_array_programmer_name(arr)
		result = ""
		arr.each do |name|
			result  += name + ", "
		end
		result.chomp(", ")
	end

	# display link to programmers
	def display_array_programmer_with_link(arr)
		result = ""
		arr.each do |programmer|
			result += link_to(programmer.name, programmer) + ", "
		end
		result = result[0..-3]
		raw result
	end
end
