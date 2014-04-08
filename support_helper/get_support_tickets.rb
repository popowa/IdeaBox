require  File.expand_path('./credential.rb', File.dirname(__FILE__))

#TODO: case一覧取得
#TODO: Trusted Advisorの値確認


support = AWS::Support::Client.new()
ta = support.describe_trusted_advisor_checks(:language => 'ja')
file = "trusted-advisor.json"

File.open(file, "r+") do |file|
    file.write(ta)
end


p ta.checks[0].id

p ta.checks[0].name
p '----------------'
p ta.checks[0].description
p '----------------'
p ta.checks[0].category  
p '----------------'
ta.checks[0].metadata.each do|meta|
  p meta
end

=begin
cases = support.resolve_case(:case_id => '19946233')

p cases.initial_case_status
cases.each do |c|
  p c.initial_case_status
end
cases.each do |case|
  p case.case_id, case.display_id, case.subject
end
=end
